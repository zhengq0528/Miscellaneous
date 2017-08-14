<head>
<style>
/* Use a transformer to link to the Panel */
.modal5 {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 20%; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
/* Modal Content */
.modal-content5 {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}
/* The Close Button */
.close5 {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}
.close5:hover,
.close5:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
</head>
<?php
?>
<!-- Trigger/Open The Modal -->
<button id="myBtn5">Connect Transformer</button>
<!-- The Modal -->
<div id="myModal5" class="modal5">
  <!-- Modal content -->
  <div class="modal-content5">
    <span class="close5">&times;</span>
    <center>
      <?php
      include('../Database/db.php');
      $sqla = "SELECT * FROM test.circuit
      WHERE jn = '$_GET[jn]' AND panel = '".$panelName."'";
      $results = $conn->query($sqla);
      $codes = array('x','X','s','S');
      $ar = array();
      while($row = $results->fetch_assoc()) {
        if(in_array($row['code'],$codes))
        {
          $ar += [$row['circuit'] => $row['code']];
        }
      }
      echo "<h3>TRANSFORMER DOOM!!!</h3>";
      echo "<br>";
      echo "<form method ='post'>";
      echo "Transformer No.:";
      echo "<input style='text-transform:uppercase' type = 'text' value ='' name = 'tname'><br><br>";

      echo "KVA:";
      echo "<input type = 'number' value ='15' name = 'kva'><br><br>";

      echo "Loss percentage:";
      echo "<input type = 'number' value ='0' name = 'loss'><br><br>";

      echo "<select id = 1 name='type'>";
      echo "<option value='Connected load from panel'>Connected load from panel</option>";
      echo "<option value='KVA only'>KVA only</option>";
      echo "<option value='Direct'>Direct</option>";
      echo "</select><br><br>";

      echo "Select Circuit:";
      echo "<select id = 1 name='selectedC'>";
      if(CompareType($type) ==2)
      {
        $index;
        for($index= 0 ; $index <= $circuit ; $index++)
        {
          if(!empty($ar[$index]))
          {
            if(!empty($ar[$index+2]) && !empty($ar[$index+4]))
            echo "<option value=$index>$index</option>";
          }
        }
      }
      else if(CompareType($type) == 1 )
      {
        $index;
        for($index= 0 ; $index <= $circuit ; $index++)
        {
          if(!empty($ar[$index]))
          {
            if(!empty($ar[$index+2]))
            echo "<option value=$index>$index</option>";
          }
        }
      }
      else
      {
        $index;
        for($index= 0 ; $index <= $circuit ; $index++)
        {
          if(!empty($ar[$index]))
          {
            echo "<option value=$index>$index</option>";
          }
        }
      }
      echo "</select>";
      echo "<br><br>";

      echo "Connect from panel:";
      echo "<input style='text-transform:uppercase' type = 'text' value ='' name = 'dpanel'><br><br>";

      echo "Enter Job number if Connecting from other jobs:";
      echo "<input style='text-transform:uppercase' type = 'text' value ='' name = 'projectjn'><br><br>";
      $volt = get3PHVOLTS($Service);
      echo "<input type= hidden name = 'volt' value = '$volt'>";
      echo "<input type= hidden name = 'tp' value = '$type'>";
      echo "<input type= hidden name = 'redo' value =  3>";
      echo "<input type= hidden name = 'panel' value = '$panelName'>";
      echo "<input type='submit' value= 'OK!' name = 'ShowTable'>";
      echo "</form>";
      ?>
    </center>
  </div>
</div>

<script>
// Get the modal
var modal5 = document.getElementById('myModal5');
// Get the button that opens the modal
var btn5 = document.getElementById("myBtn5");
// Get the <span> element that closes the modal
var span5 = document.getElementsByClassName("close5")[0];
// When the user clicks the button, open the modal
btn5.onclick = function() {
  modal5.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
span5.onclick = function() {
  modal5.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
</script>
