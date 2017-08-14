
<?php
function TranPanel($infoArray)
{
  include('../../PHP/Database/db.php');
  //echo "testing here <br>";
  $loadA=0;$loadB=0;$loadC=0;
  $panelName = $infoArray[0]; $linkpanelName = $infoArray[1]; $circuit = $infoArray[2];
  $t_type = $infoArray[3];$TranName = $infoArray[4];$djn = $infoArray[5]; $jn = $infoArray[6];
  $d_type = GetPanelType($linkpanelName,$djn);
  //echo "$d_type is here <BR>";
  $bools = 1;
  if($t_type == 1)
  {
    if($t_type != $d_type)
    {
      $bools = 2;
    }
  }
  if($bools == 1)
  {
    $sql = "SELECT * FROM test.circuit
    WHERE jn=$djn and panel = '$linkpanelName'";
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
          UpdateDB(GenSql1("watts1",$loadA,$linkpanelName,$panelName,$circuit,4,$TranName,$djn,$jn));
          UpdateDB(GenSql1("watts2",$loadB,$linkpanelName,$panelName,($circuit+2),5,$TranName,$djn,$jn));
        }
        else if($pos==3 || $pos ==4)
        {
          UpdateDB(GenSql1("watts2",$loadB,$linkpanelName,$panelName,$circuit,4,$TranName,$djn,$jn));
          UpdateDB(GenSql1("watts3",$loadA,$linkpanelName,$panelName,($circuit+2),5,$TranName,$djn,$jn));
        }
        else
        {
          UpdateDB(GenSql1("watts3",$loadB,$linkpanelName,$panelName,$circuit,4,$TranName,$djn,$jn));
          UpdateDB(GenSql1("watts2",$loadA,$linkpanelName,$panelName,($circuit+2),5,$TranName,$djn,$jn));
        }
      }
      else {
        if($pos==1 || $pos ==2)
        {
          UpdateDB(GenSql1("watts1",$loadA,$linkpanelName,$panelName,$circuit,4,$TranName,$djn,$jn));
          UpdateDB(GenSql1("watts2",$loadB,$linkpanelName,$panelName,($circuit+2),5,$TranName,$djn,$jn));
          UpdateDB(GenSql1("watts3",$loadC,$linkpanelName,$panelName,($circuit+4),6,$TranName,$djn,$jn));
        }
        else if($pos==3 || $pos ==4)
        {
          UpdateDB(GenSql1("watts2",$loadB,$linkpanelName,$panelName,$circuit,4,$TranName,$djn,$jn));
          UpdateDB(GenSql1("watts3",$loadC,$linkpanelName,$panelName,($circuit+2),5,$TranName,$djn,$jn));
          UpdateDB(GenSql1("watts1",$loadA,$linkpanelName,$panelName,($circuit+4),6,$TranName,$djn,$jn));
        }
        else
        {
          UpdateDB(GenSql1("watts3",$loadC,$linkpanelName,$panelName,$circuit,4,$TranName,$djn,$jn));
          UpdateDB(GenSql1("watts1",$loadA,$linkpanelName,$panelName,($circuit+2),5,$TranName,$djn,$jn));
          UpdateDB(GenSql1("watts2",$loadB,$linkpanelName,$panelName,($circuit+4),6,$TranName,$djn,$jn));
        }
      }
    }
    else if($t_type == 1)
    {
      $pos = $circuit%4;
      if($pos==1 || $pos ==2)
      {
        UpdateDB(GenSql1("watts1",$loadA,$linkpanelName,$panelName,$circuit,4,$TranName,$djn,$jn));
        UpdateDB(GenSql1("watts2",$loadB,$linkpanelName,$panelName,($circuit+2),5,$TranName,$djn,$jn));
        //UpdateDB(GenSql1("watts1",$loadC,$linkpanelName,$panelName,($circuit+4),6,$TranName,$djn,$jn));
      }
      else {
        UpdateDB(GenSql1("watts2",$loadB,$linkpanelName,$panelName,$circuit,4,$TranName,$djn,$jn));
        UpdateDB(GenSql1("watts1",$loadA,$linkpanelName,$panelName,($circuit+2),5,$TranName,$djn,$jn));
        //UpdateDB(GenSql1("watts2",$loadC,$linkpanelName,$panelName,($circuit+4),6,$TranName,$djn,$jn));
      }
    }
    else
    {
      $sql = "UPDATE test.circuit
      SET watts1 = '$loadA',watts2 ='$loadB',watts3 ='$loadC',code ='T', linktrans = '$TranName',
      uses ='Trans-$TranName:($linkpanelName)',linkpanel = '$linkpanelName',linkphase = '4',phase = '$djn'
      WHERE jn='$jn' and panel = '$panelName' AND circuit = '$circuit'";
      UpdateDB($sql);
    }
  }
  else
  {
    echo "<h1> Failing to use Transformer <br> Singlephase can not connect to three phase panel</h1>";
  }
}

function RecursiveTL($panelName,$djn)
{
  include('../../PHP/Database/db.php');
  $sql = "SELECT * FROM test.keys
  WHERE jn= '$_GET[jn]'";
  $result = $conn->query($sql);
  $kv = array();
  while($row = $result->fetch_assoc()) {
    $kv +=[strtoupper($row['keyname']) => $row['derating']];
  }
  $type = getTypes($panelName);
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
      $ratio = 0.5;
      if(empty($letter) ||empty($kv[$letter]))
      {
        $ratio = 1;
      }
      else
      {
        $ratio = $kv[$letter] / 100;
      }
      $load1 += ($row['watts1'] * $ratio); $load2 += ($row['watts2'] * $ratio);  $load3 += ($row['watts3'] * $ratio);
      //general and calculate total for individual keys that display on the header.
      if((strcasecmp($letter,"P")!= 0 || strcasecmp($letter,"T")!=0))
      {
        if(!empty($letter))
        {
          if(!array_key_exists(strtoupper($letter),$keyArray))
          {
            $keyArray[$letter] += $row['watts1'] + $row['watts2'] + $row['watts3'];
          }
          else
          {
            $keyArray[$letter] += $row['watts1'] + $row['watts2'] + $row['watts3'];
          }
        }
      }
    }
    else if($row['linkphase'] == 1){
      //echo "$row[linkpanel] and $row[circuit] <br>";
      $dejn = $row['phase'];
      //echo "$dejn <br>";
      $array = array($panelName,$row['linkpanel'], $row['circuit'],$t_type,$dejn,$row['jn']);
      //var_dump($array);
      //LinkToPanel($array); //updating the panel
      $l = RecursiveTL($row['linkpanel'],$dejn);
      $load1 += $l[0];
      $load2 += $l[1];
      $load3 += $l[2];
      foreach($l[3] as $key => $value) {
        $keyArray[$key] += $value;
      }
    }
    else if($row['linkphase'] == 4){

      $dejn = $row['phase'];
      $sql1 = "SELECT * FROM test.panel WHERE panel = '$panelName' and jn = '$row[jn]'";
      $result1 = $conn->query($sql1);
      $row2 = $result1->fetch_assoc();
      $t = $row2['type'];
      //echo "$t <bR>";
      $t_type = CompareType($t);
      //$array = array($_POST['panel'],$_POST['dpanel'],$_POST['selectedC'],$t_type,$_POST['tname'],$dj,$last_id);
      $array = array($panelName,$row['linkpanel'], $row['circuit'],$t_type,$row['linktrans'],$dejn,$row['jn']);
      //LinkToTrans($array); //updating the panel
      //var_dump($array);
      $l = RecursiveTL($row['linkpanel'],$dejn);
      $load1 += $l[0];
      $load2 += $l[1];
      $load3 += $l[2];
      foreach($l[3] as $key => $value) {
        $keyArray[$key] += $value;
      }
    }
  }
  $loads = array($load1,$load2,$load3,$keyArray);
  return $loads;
}
?>
