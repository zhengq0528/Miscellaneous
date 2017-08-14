<!DOCTYPE html>
<?php
include('db.php');
include('ediablecell.php');
include('CreateTable.php');
include('buttoms.php');
$table = false;$panelName = "MDP";$Location = "Dickerson Engineer";
$Service ="120/208V.,3PH.,5W";$MainBreaker = "600A-3P";$NeutralBus = "FULL SIZE";
$GroundBus="Yes";$ShortCircuitRating = 42000;
$PhaseA1 = 34.71; $PhaseA2 = 26.45;
$PhaseB1 = 30.37; $PhaseB2 = 24.37;
$PhaseC1 = 34.11; $PhaseC2 = 25.55;
$Total1  =99.19; $Total2 = 76.66;
$AMPs1 = 275.3;   $AMPs2 = 212.8; $type;
$L = 0; $M = 27.03; $T = 0; $X = 0;$R = 0; $P = 49.63; $E = 0;
$NOTE = "THIS IS FOR TESTING, MAKING IT LONGER ENOUGH TO SEE THE RESULT. HOHOHOHOHO";

?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Circuits Information</title>
  <script src="jquery.min.js"></script>
  <script src="java.js?v=1" type="text/javascript"></script>
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/dataTables.bootstrap.min.js"></script>
  <link href="style.css?v=1" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/dataTables.bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- loading the datatables-->
  <?php

  echo "Select Panel to display<br>";
  $sql = "SELECT * FROM test.panel";
  $result = $conn->query($sql);
  if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
  }
  if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
      echo "<form method='post'>";
      while(list($key,$val) = each($row))
      {
        echo "<input type='hidden' value = '$val' name = $key>";
      }
      echo "<input type='submit' value= $row[panel] name = 'ShowTable'>";
      echo "<br>";
      echo "</form>";
    }
  }
  //table creating php
  if(isset($_POST['ShowTable']))
  {
    RecursiveLinked($_POST['panel']);
    $l =RecursiveLinked($_POST['panel']);
    $PhaseA1 = $l[0];
    $PhaseB1 = $l[1];
    $PhaseC1 = $l[2];
    $R = $l[3];
    $L = $l[4];
    $panelName = $_POST['panel'];
    $Location = $_POST['location'];
    $Service = $_POST['service'];
    $mounting = $_POST['mounting'];
    $ShortCircuitRating = $_POST['rating'];
    $NeutralBus = $_POST['neutralbus'];
    $MainBreaker = "600A-3P";
    $GroundBus=$_POST['groundbus'];
    $type = $_POST['type'];
    $t_type = CompareType($type);
    if($_POST['redo']==1)
    {
      $array = array($_POST['panel'],$_POST['lpanel'],$_POST['ShowTable'],$t_type);
      LinkToPanel($array);
    }
    echo"<div class='container'>";
    echo "<h1>PANEL DATA SCHEDULE &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
    PANEL NAME: $panelName <br>
    Mount: $mounting</h1>";
    HeaderInfo($panelName,$Location,$PhaseA1,$PhaseB1,$PhaseC1,$Service,$mounting,$ShortCircuitRating
    ,$NeutralBus,$MainBreaker,$GroundBus,$R,$L);
    echo "<h4>Note is here $NOTE<h4>";?>
      <table class ="table table-striped table-bordered table-hover" id = "mydata">
        <thead>
          <tr>
            <?php
            CreateHeader();
            ?>
          </tr>
        </thead>
        <tbody>
          <?php
          $suma1 = 0;  $sumb1 = 0;  $sumc1 = 0;  $suma2 = 0;  $sumb2 = 0;  $sumc2 = 0;
          $countingCircuit = 0;
          $sql = "SELECT * FROM test.circuit
          WHERE panel = '".$panelName."'";
          $result = $conn->query($sql);

          $codes = array("p","P");
          while($row = $result->fetch_assoc()) {
            //Get data from database and store into new variables
            $id = $row['id']; $bftype =$row['bftype']; $circuit = $row['circuit']; $code = $row['code'];
            $watts3 = $row['watts3']; $watts2 = $row['watts2']; $watts1 = $row['watts1']; $uses = $row['uses'];
            $countingCircuit++;
            if($countingCircuit%2 != 0)
            {
              //This is showing on leftSide
              $suma1 +=$watts1;
              $sumb1 +=$watts2;
              $sumc1 +=$watts3;
              if(in_array($code,$codes))
              {
                echo "<td class = 'constant'><center>$row[code]</td>";
                echo "<td class = 'constant'><center>$row[uses]</td>";
                CreateLoadCell($id,$t_type,$circuit,$watts1,$watts2,$watts3,$code);
                echo "<td class = 'constant'><center>$row[circuit]</td>";
                echo "<td class = 'constant'><center>$row[bftype]</td>";
              }
              else
              {
                CreateTabelCell($id,'code',$code);
                CreateTabelCell($id,'uses',$uses);
                CreateLoadCell($id,$t_type,$circuit,$watts1,$watts2,$watts3,$code);
                echo "<td class = 'constant'><center>$row[circuit]</td>";
                CreateTabelCell($id,'bftype',$bftype);
              }
            }
            else
            {
              $suma2 +=$watts1;
              $sumb2 +=$watts2;
              $sumc2 +=$watts3;
              if(in_array($code,$codes))
              {
                echo "<td class = 'constant'><center>$row[bftype]</td>";
                echo "<td class = 'constant'><center>$row[circuit]</td>";
                CreateLoadCell($id,$t_type,$circuit,$watts1,$watts2,$watts3,$code);
                echo "<td class = 'constant'><center>$row[code]</td>";
                echo "<td class = 'constant'><center>$row[uses]</td>";
              }
              else
              {
              CreateTabelCell($id,'bftype',$bftype);
              echo "<td class = 'constant'><center>$row[circuit]</td>";
              CreateLoadCell($id,$t_type,$circuit,$watts1,$watts2,$watts3,$code);
              CreateTabelCell($id,"code",$code);
              CreateTabelCell($id,"uses",$uses);
              }
              echo "</tr>";
            }
          }
          ?>
        </tbody>
        <tfood>
          <tr>
            <?php CreateBottom($suma1,$sumb1,$sumc1,$suma2,$sumb2,$sumc2); ?>
          </tr>
        </tfood>
      </table>
      <!-- loading the datatables-->
    </div>

    <script>
    $('#mydata').dataTable(
      {
        "order": [[ 6, "desc" ]],
        "bSort" : false,
        "iDisplayLength": 50,
        //"sDom": "t",
        columnDefs: [
          { width: 10,targets: 0 },
          { width: 250, targets: 1 },
          { width: 50, targets: 2 },
          { width: 50, targets: 3 },
          { width: 50, targets: 4 },
          { width: 10, targets: 5 },
          { width: 70, targets: 6 },
          { width: 70, targets: 7 },
          { width: 10, targets: 8 },
          { width: 50, targets: 9 },
          { width: 50, targets: 10 },
          { width: 50, targets: 11 },
          { width: 10, targets: 12 },
          { width: 250, targets: 13 },
        ],
        select: {
          style:    'os',
          selector: 'td:first-child'
        },
      }
    );
    </script>
    <?php

    echo "<form action='#' method='post'>";
    echo "<input type= hidden name = 'panel' value = $panelName>";
    echo "<input type= hidden name = 'type' value = $type>";
    echo "<input type='submit' name='lk' value='Link to Panel'>";
    echo "</form>";
  }
  if(isset($_POST['lk']))
  {
    $fromPanel = $_POST['panel'];
    echo "Please Select Panel to Link.<br>";
    $sql = "SELECT * FROM test.panel";
    $result = $conn->query($sql);
    if (!$result) {
      echo 'Could not run query: ' . mysql_error();
      exit;
    }
    echo "<form action='#' method='post'>";
    echo "<input type='hidden' value= $fromPanel name = 'fromPanel'>";
    echo "<input type= hidden name = 'type' value = $_POST[type]>";
    if ($result->num_rows > 0) {
      while ($row = mysqli_fetch_array($result)) {
        if(strcmp($fromPanel,$row['panel'])!=0)
        {
          echo "<input type='submit' id = 'search' value= $row[panel] name = 'linkPanel'>";
        }
      }
    }
    echo "</form>";
  }
  if(isset($_POST['linkPanel']))
  {
    echo "From panel $_POST[fromPanel] <br>";
    $panelName = $_POST['linkPanel'];
    $loadA =0;  $loadB =0;  $loadC =0;
    echo"Select circuit of the panel to link $panelName<BR>";
    $sql = "SELECT * FROM test.circuit
    WHERE panel = '".$panelName."'";
    $result = $conn->query($sql);
    echo "<form method='post'>";
    while($row = $result->fetch_assoc()) {
      $loadA += $row['watts1'];
      $loadB += $row['watts2'];
      $loadC += $row['watts3'];
      //echo "<input type='submit' value=$row[circuit] name ='ShowTable'>";
    }
    echo "<input type= hidden name = 'type' value =  $_POST[type]>";
    echo "<input type= hidden name = 'loadA' value =  $loadA>";
    echo "<input type= hidden name = 'loadB' value =  $loadB>";
    echo "<input type= hidden name = 'loadC' value =  $loadC>";
    echo "<input type= hidden name = 'panel' value =  $_POST[fromPanel]>";
    echo "<input type= hidden name = 'lpanel' value =  $panelName>";
    echo "<input type= hidden name = 'redo' value =  1>";
    $sql = "SELECT * FROM test.circuit
    WHERE panel = '".$_POST[fromPanel]."'";
    $result = $conn->query($sql);
    echo "<form method='post'>";
    while($row = $result->fetch_assoc()) {
      echo "<input type='submit' value= $row[circuit] name = 'ShowTable'>";
      //echo "<input type='submit' value=$row[circuit] name ='ShowTable'>";
    }
    echo "</form>";
    echo "$loadA $loadB $loadC";
  }
  ?>
</body>
</html>
<script type="text/javascript">
</script>
