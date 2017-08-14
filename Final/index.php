<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>PANEL SCHEDULE SYSTEM</title>
</head>
<body>
  <div id = "titles">
    <H2><CENTER> PANEL SCHEDULE SYSTEM</H2>
    <p><CENTER> Please Enter Job Number</P>
    <form method='get' action = "PHP/Panel/PanelInterface.php">
      <input type = "text" name = "jn" value = "17001">
      <input type = "Submit">
    </form>

    <?php
      include('PHP/Database/db.php');
    ?>

    <form method='post'>
      <input type = "Submit" name = "CreateJob" value = "Create A Project">
    </form>

    <?php
      if(isset($_POST['CreateJob']))
      {
        echo "<form action='#' method='post'>";
        echo "<br><br>";
        echo "Job Number:";
        echo "<input type = 'text' value =''name = 'jn'><br><br>";
        echo "Job Descriptions:";
        echo "<input type = 'text' value =''name = 'jd'><br><br>";
        echo "Job Rating:";
        echo "<input type = 'text' value =''name = 'jr'><br><br>";
        echo "Build Type: ";
        echo "<select name='type'>";
        echo "<option value='1'>Dwelling Units</option>";
        echo "<option value='2'>Hospitals</option>";
        echo "<option value='3'>Hotels and Motels</option>";
        echo "<option value='4'>Warehouses</option>";
        echo "<option value='5'>All Others</option>";
        echo "</select> <br> <br>";
        echo " <input type='submit' name='pj' value='Create' />";
        echo "</form>";
      }
      if(isset($_POST['pj']))
      {
        $jn = $_POST['jn'];
        $jobdesc = $_POST['jd'];
        $deratingstyle = $_POST['jr'];
        $type = $_POST['type'];
        $keys = array(
          "L" => "Light",
          "R" => "Receptacle",
          "M" => "Motors",
          "E" => "Extra",
          "X" => "Space",
          "S" => "Spare"
        );
        //Select types to insert into Panel Database
        $sql = "INSERT INTO test.project(jn,jobdesc,deratingstyle,type)
        VALUES ($jn, '$jobdesc', $deratingstyle, $type)";
        if ($conn->query($sql) === TRUE) {
          echo "jn: $jn ; <br>jobdesc: $jobdesc ;
          <br>Derating style: $deratingstyle
          <br>has been added to Database";
          foreach($keys as $key => $value)
          {
            if(strcmp($key,"M") == 0)
            {
              $sql1 = "INSERT INTO test.keys(jn,keyname,description,derating) VALUES ($jn,'$key','$value','125')";
            }
            else
            {
              $sql1 = "INSERT INTO test.keys(jn,keyname,description,derating) VALUES ($jn,'$key','$value','100')";
            }
            $conn->query($sql1);
          }
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }
    ?>
  </div>
</body>
</html>
