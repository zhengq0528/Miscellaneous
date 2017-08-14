<?php
//If they want to link to panel, then redo will be 1 and do the function
if($_POST['redo']==1)
{
  $t_type = CompareType($_POST['tp']);
  $djn = $_POST['dpanel'];
  if(empty($djn))
  $djn = $_GET['jn'];
  $array = array($_POST['panel'],$_POST['lpanel'],$_POST['selectedC'],$t_type,$djn,$_GET['jn']);
  LinkPanel($array);
}
else if($_POST['redo']==2)
{
  $sql = "SELECT * from test.circuit
  WHERE jn=$_GET[jn] and panel = '$_POST[panel]' and circuit = '$_POST[ShowTable]'";
  $result = $conn->query($sql);
  $phase;
  while($row = $result->fetch_assoc()) {
    $phase = $row['linktrans'];
  }
  $sql = "DELETE FROM test.transformer
  WHERE jn = $_GET[jn] and name = '$phase'";
  $conn->query($sql);

  $sql = "UPDATE test.circuit SET code = 'S',uses =' ',watts1 = 0, watts2 = 0,watts3 =0,
  linkpanel = '', linkphase = 0
  WHERE jn=$_GET[jn] and panel = '$_POST[panel]' and circuit = '$_POST[ShowTable]'";

  if(mysqli_query($conn,$sql)){
    echo " <br>Records were updated successfully.";
  }
  else {
    echo " <br>ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }

  $t = CompareType($_POST['tp']);
  $c1 = $_POST['ShowTable'] + 2;
  $c2 = $c1 + 2;
  if($t==1 || $t ==2)
  {
    $sql = "UPDATE test.circuit SET code = 'S',uses =' ',watts1 = 0, watts2 = 0,watts3 =0,
    linkpanel = '', linkphase = 0
    WHERE jn=$_GET[jn] and panel = '$_POST[panel]' and circuit = '$c1'";
    $conn->query($sql);

    $sql = "UPDATE test.circuit SET code = 'S',uses =' ',watts1 = 0, watts2 = 0,watts3 =0,
    linkpanel = '', linkphase = 0
    WHERE jn=$_GET[jn] and panel = '$_POST[panel]' and circuit = '$c2'";
     $conn->query($sql);
  }

}
else if($_POST['redo']==3)
{
  $dj = $_POST['projectjn'];
  if(empty($_POST['projectjn']))
  $dj = $_GET['jn'];
  $t_type = CompareType($_POST['tp']);
  if(empty($_POST['tname']) || empty($_POST['dpanel']))
  echo "<h3> MISSING INPUTS TO CREATE TRANSFORMER </H3>";
  else
  {
    $sql = "SELECT * FROM test.panel WHERE jn = '$dj' and panel = '$_POST[dpanel]'";
    $result = $conn->query($sql);
    $volt;
    while ($row = mysqli_fetch_array($result)) {
      $volt = $row['service'];
    }
    $d_type = GetPanelType($_POST['dpanel'],$dj);
    $bools = 1;
    if($t_type == 1)
    {
      if($t_type != $d_type)
      {
        $bools = 2;
      }
    }

    $volts = get3PHVOLTS($volt);
    if(empty($volt) || $bools ==2 )
    {
      echo "<h3> PANEL DOES NOT EXIST!!!!, TRY AGAIN </H3>";
    }
    else if($d_type ==4)
    {
      echo "<h3> Dont need transformer </H3>";
    }
    else
    {
      $sql = "INSERT INTO test.transformer(jn,rating,source,svolt,dvolt,destination,
        phases,remark,loadtype,loss,djn,name,service)
        VALUES('$_GET[jn]','$_POST[kva]','$_POST[panel]',$_POST[volt],$volts,'$_POST[dpanel]',
          '1','Connecting $_POST[panel] to $_POST[dpanel]',
          '$_POST[type]','$_POST[loss]','$dj','$_POST[tname]','default')";
          if($conn->query($sql))
          {
            $last_id = $conn->insert_id;
            $array = array($_POST['panel'],$_POST['dpanel'],$_POST['selectedC'],$t_type,$_POST['tname'],$dj,$_GET['jn']);
            TranPanel($array);
          }
          else{
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
        }
      }
    }
    else if($_POST['redo']==4)
    {
      $location = $_POST['location'];
      $groundbus = $_POST['groundbus'];
      $rating = $_POST['rating'];
      $mounting = $_POST['mounting'];
      $service = $_POST['service'];
      $lug = $_POST['lug'];
      $breaker = $_POST['breaker'];
      $note = $_POST['note'];
      $neu = $_POST['neutralbus'];
      $ac = $_POST['aicrating'];
      if(empty($ac))
      {
        $ac = 0;
      }
      $sql = "UPDATE test.panel SET location = '$location',
      groundbus = '$groundbus',
      rating = '$rating',
      mounting = '$mounting',
      service = '$service',
      lug = '$lug',
      breaker = '$breaker',
      notes = '$note',
      neutralbus = '$neu',
      aicrating = '$ac'
      WHERE panel = '$_POST[panel]' and jn = '$_GET[jn]'";
      if(mysqli_query($conn,$sql)){
        echo " <br>Records were updated successfully.";
      }
      else {
        echo " <br>ERROR: Could not able to execute $sql. " . mysqli_error($conn);
      }
    }
    ?>
