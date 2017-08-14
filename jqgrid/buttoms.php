<?php
include('db.php');


//Select tablename from database test
$mysql = "SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema ='test'";
$result0 = $conn->query($mysql);
if (!$result0) {
  echo 'Could not run query: ' . mysql_error();
  exit;
}
echo "<h4>Choose A Data Type To Add </h4>";
if ($result0->num_rows > 0) {
  echo "<form method='post'>";
  while ($row = mysqli_fetch_array($result0)) {
    echo "<input type='submit' value= $row[TABLE_NAME] name = 'selected'>";
    echo " ";
  }
  echo "<input type='submit' value= 'Delete Panel' name = 'delete'>";
  echo "</form>";
}
if(isset($_POST['delete']))
{

  $sql = "SELECT * FROM test.panel";
  $result = $conn->query($sql);
  if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
  }
  echo "Select Panel to delete<br>";
  if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
      echo "<form method='post'>";
      echo "<input type='submit' value= $row[panel] name = 'deletePanel'>";
      echo "</form>";
    }
  }
}
if(isset($_POST['deletePanel'])){
  // sql to delete a record
  $pname = $_POST['deletePanel'];
  echo "hello $pname<br>";
  $sql = "DELETE FROM test.panel WHERE panel = '".$pname."'";

  if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
  } else {
    echo "Error deleting record: " . $conn->error;
  }
  $sql = "DELETE FROM test.circuit WHERE panel = '".$pname."'";

  if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
  } else {
    echo "Error deleting record: " . $conn->error;
  }
}
if(isset($_POST['selected']))
{
  $name = $_POST['selected'];
  $sql = "SELECT `COLUMN_NAME`
  FROM `INFORMATION_SCHEMA`.`COLUMNS`
  WHERE `TABLE_SCHEMA`='test'
  AND `TABLE_NAME`='$name'";
  $result = $conn->query($sql);
  if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
  }
  if ($result->num_rows > 0) {
    $count = 0;
    echo "<br>";
    echo "<table border='1' id='table' cellpadding='10' class='table-editable'>";
    echo "<tr>";
    $count = 0;
    while ($row = mysqli_fetch_array($result)) {
      if($count == 4)
      {
        $count =0;
        echo "<tr>";
      }
      echo "<form action='#' method='post'>";
      $s1 = $row[COLUMN_NAME];
      $s2 = "type";
      $s3 = "groundbus";
      $s4 = "circuit";
      $s5 = "phases";
      $s6 = "id";
      $s7 = "service";
      //printing COLUMN NAMES in the table
      if(strcmp($s1,$s6)!=0)
      {
        echo "<td>";
        echo "$row[COLUMN_NAME]";
        $count +=1;
      }
      if(strcmp($s1,$s2)==0)
      {
        echo "<br><select id = 1 name='type'>";
        echo "<option value='ThreePhase'>ThreePhase</option>";
        echo "<option value='Distribution'>Distribution</option>";
        echo "<option value='Switchboard'>Switchboard</option>";
        echo "<option value='SinglePanel'>SinglePanel</option>";
        echo "</select>";
        //echo "<input type = hidden value = $_POST['type'] name = 'type'>";
      }
      else if(strcmp($s1,$s3)==0)
      {
        echo "<br><select id = 2 name='groundbus'>";
        echo "<option value='Yes'>Yes</option>";
        echo "<option value='No'>No</option>";
        echo "</select>";
      }
      else if(strcmp($s1,$s7)==0)
      {
        echo "<br><select id = 1 name='service'>";
        echo "<option value='120/208V.,3PH.,4W.'>120/208V.,3PH.,4W.</option>";
        echo "<option value='120/208V.,3PH.,4W.'>120/208V.,3PH.,5W.</option>";
        echo "<option value='120/208V.,3PH.,4W.'>120/240V.,3PH.,4W.</option>";
        echo "<option value='120/208V.,3PH.,4W.'>120/240V.,3PH.,5W.</option>";
        echo "<option value='208V.,3PH.,3W.'>208V.,3PH.,3W.</option>";
        echo "<option value='208V.,3PH.,4W.'>208V.,3PH.,4W.</option>";
        echo "<option value='240V.,3PH.,3W.'>240V.,3PH.,3W.</option>";
        echo "<option value='240V.,3PH.,4W.'>240V.,3PH.,4W.</option>";
        echo "<option value='277/480V.,3PH.,4W.'>277/480V.,3PH.,4W.</option>";
        echo "<option value='277/480V.,3PH.,5W.'>277/480V.,3PH.,5W.</option>";
        echo "<option value='480V.,3PH.,3W.'>480V.,3PH.,3W.</option>";
        echo "<option value='480V.,3PH.,4W.'>480V.,3PH.,4W.</option>";
        echo "<option value='600V.,3PH.,4W.'>600V.,3PH.,4W.</option>";
        echo "<option value='600V.,3PH.,5W.'>600V.,3PH.,5W.</option>";
        echo "<option value='2400V.,3PH.,4W.'>2400V.,3PH.,4W.</option>";
        echo "<option value='2400V.,3PH.,5W.'>2400V.,3PH.,5W.</option>";
        echo "<option value='4160V.,3PH.,4W.'>4160V.,3PH.,4W.</option>";
        echo "<option value='4160V.,3PH.,5W.'>4160V.,3PH.,5W.</option>";
        echo "<option value='7200/12470V.,3PH.,4W.'>7200/12470V.,3PH.,4W.</option>";
        echo "<option value='12470V.,3PH.,3W.'>12470V.,3PH.,3W.</option>";
        echo "<option value='13200V.,3PH.,3W.'>13200V.,3PH.,3W.</option>";
        echo "<option value='13200V.,3PH.,4W.'>13200V.,3PH.,4W.</option>";
        echo "</select>";
      }
      else if(strcmp($s1,$s6)==0)
      {
      }
      else if(strcmp($s1,$s4)==0)
      echo "<br><input type = 'number' value ='' id = 't1' name = '$row[COLUMN_NAME]'>";
      else if(strcmp($s1,$s5)==0)
      echo "<br><input type = 'number' value ='' id = 't1' name = '$row[COLUMN_NAME]'>";
      else
      echo "<br><input type = 'text' value ='' id = 't1' name = '$row[COLUMN_NAME]'>";
    }
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    if(strcmp($name,"panel")==0)
    {
      echo "hello user, you are adding data to panel database, please hold<br>";
      echo " <input type='submit' name='pn' value='Adding Panel to Database' />";
    }
    if(strcmp($name,"project")==0)
    {
      echo "hello user, you are adding data to panel database, please hold<br>";
      echo " <input type='submit' name='pj' value='Adding Project to Database' />";
    }
    echo "</form>";
  }
}
//Adding project to database
if(isset($_POST['pj']))
{
  //Variables/parameter needed for panel database
  $jn = $_POST['jn'];
  $jobdesc = $_POST['jobdesc'];
  $deratingstyle = $_POST['deratingstyle'];
  //Select types to insert into Panel Database
  $sql = "INSERT INTO test.project(jn,jobdesc,deratingstyle)
  VALUES ($jn, '$jobdesc', $deratingstyle)";
  if ($conn->query($sql) === TRUE) {
    echo "jn: $jn ; <br>jobdesc: $jobdesc ; <br>Derating style: $deratingstyle <br>has been added to Database";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
//Adding panel to database
if(isset($_POST['pn']))
{
  //Variables/parameter needed for panel database
  $panel = $_POST['panel']; $type = $_POST['type'];
  //echo "type: $type <br>";
  $location = $_POST['location'];
  $circuit = $_POST['circuit'];
  if(empty($circuit))
  {
    $circuit = 42;
  }
  $service = $_POST['service']; $mounting = $_POST['mounting'];
  $rating = $_POST['rating'];
  if(empty($rating))
  {
    $rating = 10;
  }
  $aicrating = $_POST['aicrating'];
  if(empty($aicrating))
  {
    $aicrating = 10;
  }
  $phases = $_POST['phases']; $breaker = $_POST['breaker'];
  $groundbus = $_POST['groundbus']; $neutralbus = $_POST['neutralbus'];
  //echo "type: $groundbus <br>";
  $firstphase = $_POST['firstphase']; $notes = $_POST['notes'];
  //Select types to insert into Panel Database
  $sql = "INSERT INTO test.panel(panel,type,location,circuit,
    service,mounting,rating,aicrating,phases,breaker,groundbus,
    neutralbus,firstphase,notes)
    VALUES ('$panel','$type','$location','$circuit','$service',
      '$mounting','$rating','$aicrating','$phases','$breaker',
      '$groundbus','$neutralbus','$firstphase','$notes')";
      if ($conn->query($sql) === TRUE) {
        //echo "$panel $type  $location $circuit $service $mounting
        //$rating $aicrating  $phases $breaker $groundbus  $neutralbus
        //$firstphase $firstphase  $notes
        echo "<br>has been added to Database";
        //if panel created, circuit will created automatically
        $cir =1;
        while($cir <= $circuit)
        {
          $sql = "INSERT INTO test.circuit(panel,circuit,code,linkphase,uses,bftype)
          VALUES('$panel',$cir,'S',0,'SPARE','20A-1P')";
          if ($conn->query($sql) === TRUE) {
            echo "$sql
            <br>has been added to Database";
            //location.reload();
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
          $cir++;
        }
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }

    ?>
