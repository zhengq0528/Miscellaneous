<?php
//Compare the type. return as integer
function CompareType($type)
{
  if(strcmp($type,"SinglePanel") ==0)
  {
    return 1;
  }
  else if(strcmp($type,"ThreePhase")==0)
  {
    return 2;
  }
  else
  {
    return 3;
  }
}
function UpdateDB($sql)
{
  include('db.php');
  if(mysqli_query($conn,$sql)){
    //echo " <br>Records were updated successfully.";
  }
  else {
    echo " <br>ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }
}
function getTypes($panelName)
{
  include('db.php');

  $sql = "SELECT type FROM test.panel WHERE panel = '$panelName'";
  $result = $conn->query($sql);
  $type;
  while($row = $result->fetch_assoc()) {
    $type = $row['type'];
  }
  return $type;
}
function RecursiveLinked($panelName)
{
  $type = getTypes($panelName);
  $t_type = CompareType($type);
  $load1 =0; $load2 =0; $load3 =0;
  $rvalue =0;
  $lvalue =0;
  include('db.php');
  $sql = "SELECT * FROM test.circuit
  WHERE panel = '$panelName'";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()) {
    if($row['linkphase'] == 0)
    {
      $load1 += $row['watts1'];
      $load2 += $row['watts2'];
      $load3 += $row['watts3'];
      if(strcmp($row['code'],"R") == 0 || strcmp($row['code'],"r") == 0)
      {
        $rvalue +=  $row['watts1'];
        $rvalue +=  $row['watts2'];
        $rvalue +=  $row['watts3'];
      }
      if(strcmp($row['code'],"L") == 0 || strcmp($row['code'],"l") == 0)
      {
        $lvalue +=  $row['watts1'];
        $lvalue +=  $row['watts2'];
        $rvalue +=  $row['watts3'];
      }
    }
    else if($row['linkphase'] == 1){
      //echo "$row[linkpanel] and $row[circuit] <br>";
      $array = array($panelName,$row['linkpanel'], $row['circuit'],$t_type);
      LinkToPanel($array);
      $l = RecursiveLinked($row['linkpanel']);
      $load1 += $l[0];
      $load2 += $l[1];
      $load3 += $l[2];
      $rvalue +=$l[3];
      $lvalue +=$l[4];
    }
  }
  $loads = array($load1,$load2,$load3,$rvalue,$lvalue);
  //cho "$type | $load1 | $load2 |$load3<br>";
  return $loads;
}

function LinkToPanel($infoArray)
{
  include('db.php');
  $loadA=0;
  $loadB=0;
  $loadC=0;
  $panelName = $infoArray[0];
  $linkpanelName = $infoArray[1];

  $circuit = $infoArray[2];
  $circuit1 = $circuit + 2;
  $circuit2 = $circuit + 4;
  $t_type = $infoArray[3];
  $sql = "SELECT * FROM test.circuit
  WHERE panel = '$linkpanelName'";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()) {
    $loadA += $row['watts1'];
    $loadB += $row['watts2'];
    $loadC += $row['watts3'];
  }

  if($t_type == 2)
  {
    $pos = $circuit%6;
    if($pos==1 || $pos ==2)
    {
      $sql1 = "
      UPDATE test.circuit
      SET watts1 = '$loadA',
      code   = 'P',
      uses   = 'Panel:$linkpanelName',
      linkpanel = '$linkpanelName',
      linkphase = '1'
      WHERE panel = '$panelName' AND circuit = '$circuit'";
      $sql2 = "
      UPDATE test.circuit
      SET watts2 = '$loadB',
      code   = 'P',
      uses   = 'Panel:$linkpanelName',
      linkpanel = '$linkpanelName',
      linkphase = '2'
      WHERE panel = '$panelName' AND circuit = '$circuit1'";
      $sql3 = "
      UPDATE test.circuit
      SET watts3 = '$loadC',
      code   = 'P',
      uses   = 'Panel:$linkpanelName',
      linkpanel = '$linkpanelName',
      linkphase = '3'
      WHERE panel = '$panelName' AND circuit = '$circuit2'";
    }
    else if($pos==3 || $pos ==4)
    {
      $sql1 = "
      UPDATE test.circuit
      SET watts2 = '$loadB',
      code   = 'P',
      uses   = 'Panel:$linkpanelName',
      linkpanel = '$linkpanelName',
      linkphase = '1'
      WHERE panel = '$panelName' AND circuit = '$circuit'";
      $sql2 = "
      UPDATE test.circuit
      SET watts3 = '$loadC',
      code   = 'P',
      uses   = 'Panel:$linkpanelName',
      linkpanel = '$linkpanelName',
      linkphase = '2'
      WHERE panel = '$panelName' AND circuit = '$circuit1'";
      $sql3 = "
      UPDATE test.circuit
      SET watts1 = '$loadA',
      code   = 'P',
      uses   = 'Panel:$linkpanelName',
      linkpanel = '$linkpanelName',
      linkphase = '3'
      WHERE panel = '$panelName' AND circuit = '$circuit2'";
    }
    else
    {
      $sql1 = "
      UPDATE test.circuit
      SET watts3 = '$loadC',
      code   = 'P',
      uses   = 'Panel:$linkpanelName',
      linkpanel = '$linkpanelName',
      linkphase = '1'
      WHERE panel = '$panelName' AND circuit = '$circuit'";
      $sql2 = "
      UPDATE test.circuit
      SET watts1 = '$loadA',
      code   = 'P',
      uses   = 'Panel:$linkpanelName',
      linkpanel = '$linkpanelName',
      linkphase = '2'
      WHERE panel = '$panelName' AND circuit = '$circuit1'";
      $sql3 = "
      UPDATE test.circuit
      SET watts2 = '$loadB',
      code   = 'P',
      uses   = 'Panel:$linkpanelName',
      linkpanel = '$linkpanelName',
      linkphase = '3'
      WHERE panel = '$panelName' AND circuit = '$circuit2'";
    }
    UpdateDB($sql1);
    UpdateDB($sql2);
    UpdateDB($sql3);
  }
  else if( $t_type == 1)
  {
    $sql = "
    UPDATE test.circuit
    SET watts1 = '$loadA',
    code   = 'P',
    uses   = 'Panel:$linkpanelName',
    linkpanel = '$linkpanelName',
    linkphase = '1'
    WHERE panel = '$panelName' AND circuit = '$circuit';

    UPDATE test.circuit
    SET watts2 = '$loadB',
    code   = 'P',
    uses   = 'Panel:$linkpanelName',
    linkpanel = '$linkpanelName',
    linkphase = '0'
    WHERE panel = '$panelName' AND circuit = '$circuit1';

    UPDATE test.circuit
    SET watts1 = '$loadC',
    code   = 'P',
    uses   = 'Panel:$linkpanelName',
    linkpanel = '$linkpanelName',
    linkphase = '0'
    WHERE panel = '$panelName' AND circuit = '$circuit2';
    ";
    if(mysqli_multi_query($conn,$sql)){
      //echo " <br>Records were updated successfully.";
    }
    else {
      echo " <br>ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
  }
  else
  {
    $sql = "UPDATE test.circuit
    SET watts1 = '$loadA',
    watts2 = '$loadB',
    watts3 = '$loadC',
    code   = 'P',
    uses   = 'Panel:$linkpanelName',
    linkpanel = '$linkpanelName',
    linkphase = '1'
    WHERE panel = '$panelName' AND circuit = '$circuit'";
    UpdateDB($sql);
  }
}
//Draw Cell for other keys
function CreateTabelCell($id,$type,$value)
{
  //Get which is which, and importing to javascript.
  //Javascript/Ajax handling with Database. send post to database. and Modifiying it.
  $sid = $type .'_'.$id;
  $tid = $type .'_input_'.$id;
  echo "<td tabindex='0' id=$id class = '$type'><center>";
  echo "<span  id=$sid class='text'>$value</span>";
  echo "<input  type='text' class = 'editbox' id=$tid value='$value' >";
  echo  "</td>";
}
//Draw cell for loads, ABC
function CreateLoadCell($id,$t_type,$circuit,$watts1,$watts2,$watts3,$code)
{
  $codes = array("p","P");

  if(in_array($code,$codes))
  {
    echo "<td class = 'constant'><center>$watts1</td>";
    echo "<td class = 'constant'><center>$watts2</td>";
    echo "<td class = 'constant'><center>$watts3</td>";
  }
  else
  {
    //If type 1: Single Panel Mode
    if($t_type == 1)
    {
      $pos = $circuit%4;
      if($pos==1 || $pos ==2)
      {
        CreateTabelCell($id,'watts1',$watts1);
        echo "<td class = 'constant'><center>*</td>";
      }
      else if($pos==0 || $pos ==3)
      {
        echo "<td class = 'constant'><center>*</td>";
        CreateTabelCell($id,"watts2",$watts2);
      }
      echo "<td class = 'constant'><center>*</td>";
    }
    //If type 2: ThreePhase
    else if($t_type == 2)
    {
      $pos = $circuit%6;
      if($pos==1 || $pos ==2)
      {
        CreateTabelCell($id,"watts1",$watts1);
        echo "<td class = 'constant'><center>*</td>";
        echo "<td class = 'constant'><center>*</td>";
      }
      else if($pos==3 || $pos ==4)
      {
        echo "<td class = 'constant'><center>*</td>";
        CreateTabelCell($id,"watts2",$watts2);
        echo "<td class = 'constant'><center>*</td>";
      }
      else
      {
        echo "<td class = 'constant'><center>*</td>";
        echo "<td class = 'constant'><center>*</td>";
        CreateTabelCell($id,"watts3",$watts3);
      }
    }
    //If type rest: Distribution & Switchboard
    else
    {
      CreateTabelCell($id,"watts1",$watts1);
      CreateTabelCell($id,"watts2",$watts2);
      CreateTabelCell($id,"watts3",$watts3);
    }
  }
}
?>
