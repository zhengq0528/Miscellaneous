<!DOCTYPE html>
<form method='post' action = "../../index.php">
  <input type = "Submit" value = "Go Back!">
  <link href="../../STYLE/style.css?v=6" rel="stylesheet">
  <script src="../../JavaScript/OffPopup.js?v=5" type="text/javascript"></script>
  <script src="../../js/jquery.min.js"></script>
  <script src="../../js/jquery.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/jquery.dataTables.min.js"></script>
  <script src="../../js/dataTables.bootstrap.min.js"></script>
  <script src="../../JavaScript/KeyOnTouch.js?v=6" type="text/javascript"></script>
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <link href="../../css/dataTables.bootstrap.min.css" rel="stylesheet">
</form>
<?php
$jobnumber = $_GET['jn'];
include('../../PHP/Database/db.php');
//Check if job number is in the database.
$JobFound = false;
$sql1 = "SELECT * FROM test.project WHERE jn ='$jobnumber'";
$result1 = $conn->query($sql1);
$p_type; $p_types;
if(!$result1) {
  echo "The project does not exist! <br>";
  exit;
}
else {
  $JobFound = true;
  $Prow = mysqli_fetch_array($result1);
  $p_type = $Prow['type'];
}
?>
<html lang="en">
<head>
  <title>PANEL SCHEDULE SYSTEM</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <?php
  function getProjectType($p_type){
    switch ($p_type) {
      case 1:
      $p_types = "Dwelling units";
      break;
      case 2:
      $p_types = "Hospitals";
      break;
      case 3:
      $p_types = "Hotels and motels";
      break;
      case 4:
      $p_types = "Warehouses";
      break;
      case 5:
      $p_types = "All Others";
      break;
    }
    return $p_types;
  }

  //style="background-color:#39ac39;"
  echo"<h3> You are working on job number: $jobnumber  Type: ".getProjectType($p_type)."</h3>";


  if($JobFound)
  {
    include('../../PHP/Panel/CreatePanel.php');
    include('../../PHP/Panel/DeletePanel.php');
    include('../../PHP/Functions/Methods.php');
    include('../../PHP/Functions/Cal_Link_Panel.php');
    //include('../../PHP/Elements/ExportFunction.php');
    ?>
    <div class ="divTable">
    <div class ="divTableBody">
      <div class ="divTableRow">
          <div class = "divTableCell"> <?php include('../../PHP/Buttoms/CreatePanel.php'); ?> </div>
          <div class = "divTableCell"> <?php include('../../PHP/Buttoms/CreateThree.php'); ?> </div>
          <div class = "divTableCell"> <?php include('../../PHP/Buttoms/CreateSingle.php'); ?> </div>
          <div class = "divTableCell"> <?php include('../../PHP/Buttoms/IsolationPanel.php'); ?> </div>
          <div class = "divTableCell"> <?php include('../../PHP/Buttoms/DeletePanel.php'); ?> </div>
          <div class = "divTableCell"> <?php include('../../PHP/Buttoms/ShowTransTable.php'); ?> </div>
          <div class = "divTableCell"> <?php include('../../PHP/Buttoms/KeyTable.php'); ?> </div>
          <div class = "divTableCell"> <?php include('../../PHP/Buttoms/exportall.php'); ?> </div>
      </div>
    </div>
    </div>
    <?php
    echo "<section>";
    echo "<div id='one'>";
    //Displaying the Panels in the project.
    include('ListPanel.php');
    echo "</div>";
    echo "<div id='two'>";
    include('CircuitTable.php');
    include('TransTable.php');
    include('KeyTable.php');
    displayKeys();
    //Displaying circuit Table of individual Panels
    echo "</div>";
    echo "</section>";
    //include('../Elements/ExportData.php');

  }
  ?>
</body>
</html
