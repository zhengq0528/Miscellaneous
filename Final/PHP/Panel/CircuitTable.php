<?php
if(isset($_POST['ShowTable']))
{
  include('../DataTable/LinkPanel.php');
  include('../DataTable/TranPanel.php');
  include('../Database/db.php');
  include('../DataTable/GenerateTable.php');
  echo "<script src=''../../JavaScript/NotifyClose.js?v=2' type='text/javascript'></script>";
  $panelName = $_POST['panel'];
  $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
  //$sql = "SELECT * from test.tracklog WHERE panel = '$panelName' and jn = '$_GET[jn]' and id = (SELECT MAX(id) from test.tracklog)";
  $sql = "SELECT * FROM test.tracklog WHERE panel = '$panelName' and jn = '$_GET[jn]' ORDER BY id DESC LIMIT 0, 1";
  $result = $conn->query($sql);
  $row = mysqli_fetch_array($result);
  if($row['state'] == 0 && !empty($row) && strcmp($hostname,$row['user'])!=0)
  {
    include('../Elements/Blocking.php');
    $sql5 = "SELECT * FROM test.panel WHERE panel = '$panelName' and jn = '$_GET[jn]'";
    include('../Functions/HandleCall.php');
    $resultMain = $conn->query($sql5);
    $row = mysqli_fetch_array($resultMain);
    $type = $row['type']; $circuit = $row['circuit'];$aicrating = $row['aicrating'];
    $Location = $row['location']; $lug = $row['lug'];  $note = $row['notes']; $NeutralBus = $row['neutralbus'];
    $MainBreaker = $row['breaker']; $ShortCircuitRating = $row['rating']; $Service = $row['service'];
    //Handling updating the panel, link panel, tran panel and reset the panel
    $t_type = CompareType($type);
    if($t_type == 1)
    {
      //single phase panel
      include('../DataTable/SinglePanel.php');
    }
    else if($t_type ==4)
    {
      //Isolation Panel
      include('../DataTable/IsolationPanel.php');
    }
    else {
      //other panel
      include('../DataTable/ThreePanel.php');
    }
  }
  else
  {
    echo '<script type="text/javascript">',
    'SetClose();',
    '</script>';
    $sql = "INSERT INTO test.tracklog(jn,user,state,panel,note)
    VALUES('$_GET[jn]','$hostname','0','$panelName','$hostname is editing')";
    if($conn->query($sql))
    {
      $lastid = $conn->insert_id;
    }



    $sql5 = "SELECT * FROM test.panel WHERE panel = '$panelName' and jn = '$_GET[jn]'";
    include('../Functions/HandleCall.php');
    $resultMain = $conn->query($sql5);
    $row = mysqli_fetch_array($resultMain);
    $type = $row['type']; $circuit = $row['circuit'];$aicrating = $row['aicrating'];
    $Location = $row['location']; $lug = $row['lug'];  $note = $row['notes']; $NeutralBus = $row['neutralbus'];
    $MainBreaker = $row['breaker']; $ShortCircuitRating = $row['rating']; $Service = $row['service'];
    //Handling updating the panel, link panel, tran panel and reset the panel
    $t_type = CompareType($type);
    if($t_type == 1)
    {
      //single phase panel
      include('../DataTable/SinglePanel.php');
    }
    else if($t_type ==4)
    {
      //Isolation Panel
      include('../DataTable/IsolationPanel.php');
    }
    else {
      //other panel
      include('../DataTable/ThreePanel.php');
    }
  }
}
?>
