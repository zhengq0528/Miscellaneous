<?php
//Get 3PH volt from service
function get3PHVOLTS($Service)
{
  $contain;
  if(strpos($Service,'/')!==false)
  {
    $contain = true;
  }
  if($contain)
  {
    return get_string_between($Service,'/','V');
  }
  else
  {
    $arr = explode("V",$Service);
    return $arr[0];
  }
}
function get_string_between($string, $start, $end){
  //Helper function for get3PHvolts
  $string = ' ' . $string;
  $ini = strpos($string, $start);
  if ($ini == 0) return '';
  $ini += strlen($start);
  $len = strpos($string, $end, $ini) - $ini;
  return substr($string, $ini, $len);
}

//Compare the type. return as integer
function CompareType($type)
{
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
//Get type name by using panel name
function getTypes($panelName)
{
  include('../../PHP/Database/db.php');

  $sql = "SELECT type FROM test.panel WHERE jn=$_GET[jn] and panel = '$panelName'";
  $result = $conn->query($sql);
  $type;
  while($row = $result->fetch_assoc()) {
    $type = $row['type'];
  }
  return $type;
}

//Get type name by using panel name and jn
function getTypesJn($panelName,$jn)
{
  include('../../PHP/Database/db.php');

  $sql = "SELECT type FROM test.panel WHERE jn='$jn' and panel = '$panelName'";
  $result = $conn->query($sql);
  $type;
  while($row = $result->fetch_assoc()) {
    $type = $row['type'];
  }
  return $type;
}

//Update the database, quick call
function UpdateDB($sql)
{
  include('../../PHP/Database/db.php');
  if(mysqli_query($conn,$sql)){
  }
  else {
    echo "<br>ERROR: Could not able to execute $sql.".mysqli_error($conn);
  }
}

//Generate SQL command for linking the panel. It might also work for transfering panel
function GenSql($watts,$load,$linkpanelName,$panelName,$circuit,$lp,$djn,$jn)
{
  return "UPDATE test.circuit SET $watts = '$load',code = 'P',
  uses = 'Panel:$linkpanelName',linkpanel = '$linkpanelName',linkphase = '$lp',phase = '$djn'
  WHERE jn=$jn and  panel = '$panelName' AND circuit = '$circuit'";
}
function GenSql1($watts,$load,$linkpanelName,$panelName,$circuit,$lp,$name,$djn,$jn)
{
  return "UPDATE test.circuit SET $watts = '$load',code = 'T', linktrans = '$name',
  uses = 'Trans-$name:($linkpanelName)',linkpanel = '$linkpanelName',linkphase = '$lp',phase = '$djn'
  WHERE jn='$jn' and  panel = '$panelName' AND circuit = '$circuit'";
}

//Draw Cell for other keys
function CreateTabelCell($id,$type,$value)
{
  //Javascript/Ajax handling with Database. send post to database. and Modifiying it.
  $sid = $type .'_'.$id;
  $tid = $type .'_input_'.$id;
  echo "<td tabindex='0' id=$id class = '$type'><center>";
  echo "<span style='text-transform:uppercase' id=$sid class='text'>$value</span>";
  echo "<input style='text-transform:uppercase' type='text' class = 'editbox' id=$tid value='$value' >";
  echo  "</td>";
}

//Draw cell for loads, ABC
function CreateLoadCell($id,$t_type,$circuit,$watts1,$watts2,$watts3,$code)
{
  $codes = array("p","P","t","T");
  if(in_array($code,$codes))
  {
    echo "<td class = 'constant'><center>$watts1</td>";
    echo "<td class = 'constant'><center>$watts2</td>";
    if($t_type ==1)
      echo "<td class = 'constant'><center>*</td>";
    else
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

//Draw cell for loads, ABC
function CreateLoadCell1($id,$t_type,$circuit,$watts1,$watts2,$watts3,$code)
{
  $codes = array("p","P","t","T");
  if(in_array($code,$codes))
  {
    echo "<td class = 'constant'><center>$watts1</td>";
    echo "<td class = 'constant'><center>$watts2</td>";
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
    }
    //If type rest: Distribution & Switchboard
    else
    {
      CreateTabelCell($id,"watts1",$watts1);
      CreateTabelCell($id,"watts2",$watts2);
    }
  }
}


?>
