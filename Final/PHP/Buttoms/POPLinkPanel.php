<head>
<style>
/* Link A panel, Required text fields to get panel infos*/
.modal3 {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
/* Modal Content */
.modal-content3 {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}
/* The Close Button */
.close3 {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}
.close3:hover,
.close3:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
</head>
<?php
include('db.php');
?>
<!-- Trigger/Open The Modal -->
<button id="myBtn3">Connect Panel</button>
<!-- The Modal -->
<div id="myModal3" class="modal3">
  <!-- Modal content -->
  <div class="modal-content3">
    <span class="close3">&times;</span>
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
    echo "<h3>You are linking to A Panel!!!</h3>";
    echo "<br>";
    echo "<form method ='post'>";
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
echo "<br>";    echo "<br>";
echo "Select Destination Panel:";
echo "<input style='text-transform:uppercase' type = text name = 'lpanel' value = ''>";
echo "<br>";    echo "<br>";
echo "<input type= hidden name = 'panel' value =  $panelName>";
echo "<br>";
echo "Enter Job Number if Connecting from Other Projects
<input style='text-transform:uppercase' type = text name = 'dpanel' value = ''>";
echo "<br>";    echo "<br>";
echo "<input type= hidden name = 'tp' value = '$type'>";
echo "<input type= hidden name = 'redo' value =  1>";
echo "<input type='submit' value= 'OK!' name = 'ShowTable'>";
echo "</form>"
?>
</div>
</div>

<script>
// Get the modal
var modal3 = document.getElementById('myModal3');
// Get the button that opens the modal
var btn3 = document.getElementById("myBtn3");
// Get the <span> element that closes the modal
var span3 = document.getElementsByClassName("close3")[0];
// When the user clicks the button, open the modal
btn3.onclick = function() {
  modal3.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
span3.onclick = function() {
  modal3.style.display = "none";
}

</script>
