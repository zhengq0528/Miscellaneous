<?php
//Get type name by using panel name
function GetPanelType($panelName,$jn)
{
  include('../../PHP/Database/db.php');

  $sql = "SELECT type FROM test.panel WHERE jn='$jn' and panel = '$panelName'";
  $result = $conn->query($sql);
  $type;
  while($row = $result->fetch_assoc()) {
    $type = $row['type'];
  }
  if(strcmp($type,"SinglePhase") ==0)
  {
    return 1;
  }
  else if(strcmp($type,"ThreePhase")==0)
  {
    return 2;
  }
  else if(strcmp($type,"Isolation")==0)
  {
    return 4;
  }
  else
  {
    return 3;
  }
}
function LinkPanel($infoArray)
{
  include('../../PHP/Database/db.php');
  //Receiving informations to create connections
  $panel = $infoArray[0];  $DesPanel = $infoArray[1];  $circuit = $infoArray[2];
  $t_type = $infoArray[3];  $desjn = $infoArray[4];  $jn = $infoArray[5];
  $loadA=0; $loadB=0; $loadC=0; $OSer; $DSer; $d_type = GetPanelType($DesPanel,$desjn);
  //Get two panel volt and Compare
  $sql = "SELECT service FROM test.panel WHERE jn='$jn' and panel = '$panel'";
  $row = $conn->query($sql)->fetch_assoc();
  $OSer= $row['service'];
  $sql = "SELECT * FROM test.panel WHERE jn='$desjn' and panel = '$DesPanel'";
  $row = $conn->query($sql)->fetch_assoc();
  $DSer= $row['service'];
  $bools = 1;
  if($t_type == 1)
  {
    if($t_type != $d_type && $d_type !=4)
    {
      $bools = 2;
    }
  }
  if(get3PHVOLTS($DSer)==get3PHVOLTS($OSer) && $bools ==1)
  {
    $sql = "SELECT * FROM test.circuit
    WHERE jn=$desjn and panel = '$DesPanel'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
      $loadA += $row['watts1']; $loadB += $row['watts2']; $loadC += $row['watts3'];
    }
    if($t_type == 2)
    {
      $pos = $circuit%6;
      if($d_type == 1)
      {
        if($pos==1 || $pos ==2)
        {
          UpdateDB(GenSql("watts1",$loadA,$DesPanel,$panel,$circuit,1,$desjn,$jn));
          UpdateDB(GenSql("watts2",$loadB,$DesPanel,$panel,($circuit+2),2,$desjn,$jn));
        }
        else if($pos==3 || $pos ==4)
        {
          UpdateDB(GenSql("watts2",$loadB,$DesPanel,$panel,$circuit,1,$desjn,$jn));
          UpdateDB(GenSql("watts3",$loadA,$DesPanel,$panel,($circuit+2),2,$desjn,$jn));
        }
        else
        {
          UpdateDB(GenSql("watts3",$loadB,$DesPanel,$panel,$circuit,1,$desjn,$jn));
          UpdateDB(GenSql("watts2",$loadA,$DesPanel,$panel,($circuit+2),2,$desjn,$jn));
        }
      }
      else if($d_type == 4)
      {
        if($pos==1 || $pos ==2)
        {
          UpdateDB(GenSql("watts1",($loadA/2),$DesPanel,$panel,$circuit,1,$desjn,$jn));
          UpdateDB(GenSql("watts2",($loadA/2),$DesPanel,$panel,($circuit+2),2,$desjn,$jn));
        }
        else if($pos==3 || $pos ==4)
        {
          UpdateDB(GenSql("watts2",($loadA/2),$DesPanel,$panel,$circuit,1,$desjn,$jn));
          UpdateDB(GenSql("watts3",($loadA/2),$DesPanel,$panel,($circuit+2),2,$desjn,$jn));
        }
        else
        {
          UpdateDB(GenSql("watts3",($loadA/2),$DesPanel,$panel,$circuit,1,$desjn,$jn));
          UpdateDB(GenSql("watts2",($loadA/2),$DesPanel,$panel,($circuit+2),2,$desjn,$jn));
        }
      }
      else
      {
        if($pos==1 || $pos ==2)
        {
          UpdateDB(GenSql("watts1",$loadA,$DesPanel,$panel,$circuit,1,$desjn,$jn));
          UpdateDB(GenSql("watts2",$loadB,$DesPanel,$panel,($circuit+2),2,$desjn,$jn));
          UpdateDB(GenSql("watts3",$loadC,$DesPanel,$panel,($circuit+4),3,$desjn,$jn));
        }
        else if($pos==3 || $pos ==4)
        {
          UpdateDB(GenSql("watts2",$loadB,$DesPanel,$panel,$circuit,1,$desjn,$jn));
          UpdateDB(GenSql("watts3",$loadC,$DesPanel,$panel,($circuit+2),2,$desjn,$jn));
          UpdateDB(GenSql("watts1",$loadA,$DesPanel,$panel,($circuit+4),3,$desjn,$jn));
        }
        else
        {
          UpdateDB(GenSql("watts3",$loadC,$DesPanel,$panel,$circuit,1,$desjn,$jn));
          UpdateDB(GenSql("watts1",$loadA,$DesPanel,$panel,($circuit+2),2,$desjn,$jn));
          UpdateDB(GenSql("watts2",$loadB,$DesPanel,$panel,($circuit+4),3,$desjn,$jn));
        }
      }
    }
    else if($t_type == 1)
    {
      $pos = $circuit%4;

      if($d_type == 4)
      {
        if($pos==1 || $pos ==2)
        {
          UpdateDB(GenSql("watts1",($loadA/2),$DesPanel,$panel,$circuit,1,$desjn,$jn));
          UpdateDB(GenSql("watts2",($loadA/2),$DesPanel,$panel,($circuit+2),2,$desjn,$jn));
        }
        else {
          UpdateDB(GenSql("watts2",($loadA/2),$DesPanel,$panel,$circuit,1,$desjn,$jn));
          UpdateDB(GenSql("watts1",($loadA/2),$DesPanel,$panel,($circuit+2),2,$desjn,$jn));
        }
      }
      else{
        if($pos==1 || $pos ==2)
        {
          UpdateDB(GenSql("watts1",$loadA,$DesPanel,$panel,$circuit,1,$desjn,$jn));
          UpdateDB(GenSql("watts2",$loadB,$DesPanel,$panel,($circuit+2),2,$desjn,$jn));
        }
        else {
          UpdateDB(GenSql("watts2",$loadA,$DesPanel,$panel,$circuit,1,$desjn,$jn));
          UpdateDB(GenSql("watts1",$loadB,$DesPanel,$panel,($circuit+2),2,$desjn,$jn));
        }
      }
    }
    else
    {
      if($d_type == 4)
      {
        $als = $loadA/2;
        $sql = "UPDATE test.circuit
        SET watts1 = '$als',watts2 ='$als',code ='P',
        uses ='Panel:$DesPanel',linkpanel = '$DesPanel',linkphase = '1',phase = '$desjn'
        WHERE jn=$jn and panel = '$panel' AND circuit = '$circuit'";
      }
      else
      {
        $sql = "UPDATE test.circuit
        SET watts1 = '$loadA',watts2 ='$loadB',watts3 ='$loadC',code ='P',
        uses ='Panel:$DesPanel',linkpanel = '$DesPanel',linkphase = '1',phase = '$desjn'
        WHERE jn=$jn and panel = '$panel' AND circuit = '$circuit'";
      }
      UpdateDB($sql);
    }
  }
  else {
    echo "<h1> Failing to Link a Panel</h1>";
    if($bools != 1)
    {
      echo "<h3>Singlephase Panel Can Not Connect to Three Phase Panel</h3>";
    }
  }
}

function RecursiveCalCulateConnectLoad($panelName,$djn)
{

  //include('../../PHP/Database/db.php');
  $type = getTypesJn($panelName,$djn);
  $t_type = CompareType($type);
  $load1 =0; $load2 =0; $load3 =0;
  $keyArray = array();


  $sql = "SELECT * FROM test.circuit
  WHERE jn= '$djn' and panel = '$panelName'";
  $result = $conn->query($sql);

  while($row = $result->fetch_assoc()) {
    $letter = strtoupper($row['code']);
    if($row['linkphase'] == 0)
    {
      $load1 += $row['watts1'];    $load2 += $row['watts2'];      $load3 += $row['watts3'];
      if(!empty($letter))
      {
        if(!array_key_exists(strtoupper($letter),$keyArray))
        $keyArray[$letter] += $row['watts1'] + $row['watts2'] + $row['watts3'];
        else
        $keyArray[$letter] += $row['watts1'] + $row['watts2'] + $row['watts3'];
      }
    }
    else if($row['linkphase'] == 1){
      $array = array($panelName,$row['linkpanel'], $row['circuit'],$t_type,$row['phase'],$row['jn']);
      LinkPanel($array); //updating the panel
      $l = RecursiveCalCulateConnectLoad($row['linkpanel'],$row['phase']);
      if(GetPanelType($row['linkpanel'],$row['phase'])==4)
      {
        $load1 += ($l[0]/2);  $load2 += ($l[0]/2);
      }
      else
      {
        $load1 += $l[0];  $load2 += $l[1];  $load3 += $l[2];
      }
      foreach($l[3] as $key => $value) {
        $keyArray[$key] += $value;
      }
    }
    else if($row['linkphase'] == 4){
      $array = array($panelName,$row['linkpanel'], $row['circuit'],$t_type,$row['linktrans'],$row['phase'],$row['jn']);
      TranPanel($array);
      $l = RecursiveCalCulateConnectLoad($row['linkpanel'],$row['phase']);
      $load1 += $l[0]; $load2 += $l[1]; $load3 += $l[2];
      foreach($l[3] as $key => $value) {
        $keyArray[$key] += $value;
      }
    }
  }
  $loads = array($load1,$load2,$load3,$keyArray);
  return $loads;
}

?>
