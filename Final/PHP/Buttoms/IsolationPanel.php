<head>
<style>
/* Dis connect a panel or transformet.*/
.modal6 {
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
.modal-content6 {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}
/* The Close Button */
.close6 {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}
.close6:hover,
.close6:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
</head>
<?php
?>
<!-- Trigger/Open The Modal -->
<button style="height:40px;width:150px" id="myBtn6">Create Isolation Panel</button>
<!-- The Modal -->
<div id="myModal6" class="modal6">
  <!-- Modal content -->
  <div class="modal-content6">
    <span class="close6">&times;</span>
    <H3>CREATE A ISOLATION PANEL!</h3>
      <center>
      <?php
      echo "<form action='#' method='post'>";
      echo "panel: ";
      echo "<input type = 'text' style='text-transform:uppercase' name = 'panel' value ='I1'>  <br><br>";
      //Type
      echo "type: ";
      echo "<select id = 1 name='type'>";
      echo "<option value='Isolation'>Isolation</option>";
      echo "</select> <br> <br>";

      //Location
      echo "Location: ";
      echo "<input type = 'text' value ='' name = 'location'> <br> <br>";

      //circuit
      echo "Circuit Number: ";
      echo "<select id = 1 name='circuit'>";
      echo "<option value='8'>8</option>";
      echo "<option value='10'>10</option>";
      echo "<option value='12'>12</option>";
      echo "<option value='14'>14</option>";
      echo "<option value='16'>16</option>";
      echo "</select> <br> <br>";
      //service
      echo "Service: ";
      echo "<select id = 1 name='service'>";
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
      echo "</select> <br> <br>";

      //mounting
      echo "mounting: ";
      echo "<select id = 1 name='mounting'>";
      echo "<option value='Surface'>Surface</option>";
      echo "<option value='Flush'>Flush</option>";
      echo "</select> <br> <br>";

      //rating
      echo "Main Lugs: ";
      echo "<input type = 'text' value ='' name = 'lug'> <br> <br>";

      //rating
      echo "Short Circuit Rating: ";
      echo "<input type = 'number' value ='' name = 'rating'> <br> <br>";

      //neutralbus
      echo "TRANSFORMER SIZE: ";
      //echo "<input type = 'text' value ='' name = 'neutralbus'> <br> <br>";
      echo "<select id = 1 name='neutralbus'>";
      echo "<option value='3'>3</option>";
      echo "<option value='5'>5</option>";
      echo "<option value='7.5'>7.5</option>";
      echo "<option value='10'>10</option>";
      echo "<option value='12.5'>12.5</option>";
      echo "<option value='25'>25</option>";
      echo "</select> <br> <br>";

      //aicrating
      echo "SECONDARY VOLTAGE: ";
      //echo "<input type = 'number' value ='' name = 'aicrating'> <br> <br>";
      echo "<select id = 1 name='aicrating'>";
      echo "<option value='120'>120</option>";
      echo "<option value='208'>208</option>";
      echo "<option value='240'>240</option>";
      echo "<option value='277'>277</option>";
      echo "<option value='480'>480</option>";
      echo "</select> <br> <br>";

      //phase
      //echo "Phase: ";
      echo "<input type = hidden value ='' name = 'phases'>";

      //Breaker
      echo "Breaker: ";
      echo "<input type = 'text' value ='' name = 'breaker'> <br> <br>";

      //groundbus
      echo "LINE ISOLATION MONITOR: ";
      echo "<select id = 2 name='groundbus'>";
      echo "<option value='Yes'>Yes</option>";
      echo "<option value='No'>No</option>";
      echo "</select> <br> <br>";


      //neutralbus
      //echo "firstphase: ";
      echo "<input type = 'hidden' value ='' name = 'firstphase'>";

      //neutralbus
      echo "notes: ";
      echo "<input type = 'text' value ='' name = 'notes'> <br> <br>";

      echo " <input type='submit' name='isop' value='Adding Panel to Database'/>";
      echo "</form>";

      ?>
    </center>
    </div>
  </div>

  <script>
  // Get the modal
  var modal6 = document.getElementById('myModal6');
  // Get the button that opens the modal
  var btn6 = document.getElementById("myBtn6");
  // Get the <span> element that closes the modal
  var span6 = document.getElementsByClassName("close6")[0];
  // When the user clicks the button, open the modal
  btn6.onclick = function() {
    modal6.style.display = "block";
  }
  // When the user clicks on <span> (x), close the modal
  span6.onclick = function() {
    modal6.style.display = "none";
  }
  </script>
