<head>
<style>
/* Update a panel, with the new infos
    Test fields are here*/
.modal {
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
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}
/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}
.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
</head>
<?php
?>
<!-- Trigger/Open The Modal -->
<button onclick="clicked()">Edit Isolation Panel</button>
<!-- The Modal -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span onclick="touch()" class="close">&times;</span>
    <center>
      <p>Panel Information</p>
      <form action='#' method='post'>
        <?php echo "Location: <input type = 'text' name = 'location' value = '$Location'> "?><br><br>
        Service:
        <?php
        echo "<select id = 1 name='service' value = '$Service'>";
        echo "<option value='120/120V.,1PH.,3W.'>120/120V.,1PH.,3W.</option>";
        echo "<option value='120/208V.,1PH.,3W.'>120/208V.,1PH.,3W.</option>";
        echo "<option value='120/240V.,1PH.,3W.'>120/240V.,1PH.,3W.</option>";
        echo "<option value='120/277V.,1PH.,3W.'>120/277V.,1PH.,3W.</option>";
        echo "<option value='120/480V.,1PH.,3W.'>120/480V.,1PH.,3W.</option>";
        echo "<option value='208/120V.,1PH.,3W.'>208/120V.,1PH.,3W.</option>";
        echo "<option value='208/208V.,1PH.,3W.'>208/208V.,1PH.,3W.</option>";
        echo "<option value='208/240V.,1PH.,3W.'>208/240V.,1PH.,3W.</option>";
        echo "<option value='208/277V.,1PH.,3W.'>208/277V.,1PH.,3W.</option>";
        echo "<option value='208/480V.,1PH.,3W.'>208/480V.,1PH.,3W.</option>";
        echo "</select>";
        ?><br><br>
        Mounting: <?php
        echo "<select id = 1 name='mounting'>";
        echo "<option value='Surface'>Surface</option>";
        echo "<option value='Flush'>Flush</option>";
        echo "</select>";
        ?> <br><br>
        <?php echo "Short Circuit Rating: <input type = 'text' name = 'rating' value = '$ShortCircuitRating'> "?> <br><br>
        <?php echo "Main Breaker: <input type = 'text' name = 'breaker' value = '$MainBreaker'> "?> <br><br>
        LINE isolation MONITOR:
        <?php
        echo "<select id = 2 name='groundbus'>";
        echo "<option value='Yes'>Yes</option>";
        echo "<option value='No'>No</option>";
        echo "</select>";
        echo "<input type ='hidden' value = '$panelName' name = 'panel'>";
        ?>
        <br><br>
        <?php //echo "TRANSFORMER SIZE: <input type = 'text' name = 'neutralbus' value = '$NeutralBus'> "
        echo "TRANSFORMER SIZE: ";
        //echo "<input type = 'text' value ='' name = 'neutralbus'> <br> <br>";
        echo "<select id = 1 name='neutralbus' value = '$NeutralBus'>";
        echo "<option value='3'>3</option>";
        echo "<option value='5'>5</option>";
        echo "<option value='7.5'>7.5</option>";
        echo "<option value='10'>10</option>";
        echo "<option value='12.5'>12.5</option>";
        echo "<option value='25'>25</option>";
        echo "</select> <br> <br>";
        ?>
        <?php
        //echo "SECONDARY VOLTAGE: <input type = 'text' name = 'aicrating' value = '$aicrating'> "
        echo "SECONDARY VOLTAGE:";
        echo "<select name='aicrating' value = '$aicrating'>";
        echo "<option value='120'>120</option>";
        echo "<option value='208'>208</option>";
        echo "<option value='240'>240</option>";
        echo "<option value='277'>277</option>";
        echo "<option value='480'>480</option>";
        echo "</select> <br> <br>";
        ?>
        <?php echo "Main LUG: <input type = 'text' name = 'lug' value = '$lug'> "?><br><br>
        <?php echo "Note: <input type = 'text' name = 'note' value = '$note'> "?> <br><br>
        <?php echo "<input type='hidden' value= '4' name = 'redo'>";?>
        <?php echo "<input type = 'submit' name = 'ShowTable' value = 'Update'>"; ?>
      </form>
    </center>
  </div>
</div>

<script>
// Get the modal
var modal = document.getElementById('myModal');
// Get the button that opens the modal
var btn = document.getElementById("myBtn");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks the button, open the modal
function clicked() {
  modal.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
function touch() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it

</script>
