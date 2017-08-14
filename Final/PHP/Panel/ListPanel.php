<?php
  echo "<H2>Select Panel</H2><br>";
  $sql = "SELECT * FROM test.panel WHERE jn = '$_GET[jn]'";
  $result = $conn->query($sql);
  if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
  }
  if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
      //exportPanel($row['panel']);
      echo "<form method='post'>";
      while(list($key,$val) = each($row))
      {
        echo "<input type='hidden' value = '$val' name = $key>";
      }
      //echo "<input type ='hidden' value = '$row[panel]' name = 'export'>";
      echo "<input style='height:40px;width:160px;'
      type='submit' value= $row[panel] name = 'ShowTable'>";
      echo "<br>";
      echo "</form>";
    }
  }
?>
