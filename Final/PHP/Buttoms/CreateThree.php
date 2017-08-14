
<head>
<style>
/* The first Buttoms of the panel schedule system --- Creating Buttoms
  You Can add more element or Info that you need when you create a new panel*/
.modal8 {
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
.modal-content8 {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}
/* The Close Button */
.close8 {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
.close8:hover,
.close8:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>
</head>
<?php
?>
<!-- Trigger/Open The Modal -->
<button style="height:40px;width:150px" id="myBtn8">Create ThreePhase Panel</button>
<!-- The Modal -->
<div id="myModal8" class="modal8">
  <!-- Modal content -->
  <div class="modal-content8">
    <span class="close8">&times;</span>
    <center>
    <?php
    //panel
    echo "<form action='#' method='post'>";
    echo "panel: ";
    echo "<input type = 'text' style='text-transform:uppercase' name = 'panel' value =''>  <br><br>";
    //Type
    echo "type: ";
    echo "<select id = 1 name='type'>";
    echo "<option value='ThreePhase'>ThreePhase</option>";
    echo "</select> <br> <br>";

    //Location
    echo "Location: ";
    echo "<input type = 'text' value ='' name = 'location'> <br> <br>";

    //circuit
    echo "Circuit Number: ";
    echo "<select id = 1 name='circuit'>";
    $index = 2;
    for($index = 1;$index < 84; $index++)
    {
      $index+=5;
      echo "<option value='$index'>$index</option>";
    }
    echo "</select> <br> <br>";
    //echo "<input type = 'number' value ='14' name = 'circuit'> <br> <br>";

    //service
    echo "Service: ";
    echo "<select id = 1 name='service'>";
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

    //aicrating
    echo "AICraing: ";
    echo "<input type = 'number' value ='' name = 'aicrating'> <br> <br>";

    //phase
    //echo "Phase: ";
    echo "<input type = hidden value ='' name = 'phases'>";

    //Breaker
    echo "Breaker: ";
    echo "<input type = 'text' value ='' name = 'breaker'> <br> <br>";

    //groundbus
    echo "groundbus: ";
    echo "<select id = 2 name='groundbus'>";
    echo "<option value='Yes'>Yes</option>";
    echo "<option value='No'>No</option>";
    echo "</select> <br> <br>";
    //neutralbus

    echo "Neutralbus: ";
    echo "<input type = 'text' value ='' name = 'neutralbus'> <br> <br>";

    //neutralbus
    //echo "firstphase: ";
    echo "<input type = 'hidden' value ='' name = 'firstphase'>";

    //neutralbus
    echo "notes: ";
    echo "<input type = 'text' value ='' name = 'notes'> <br> <br>";

    echo " <input type='submit' name='apn' value='Adding Panel to Database'/>";
    echo "</form>";

    ?>
  </center>
  </div>
</div>

<script>
// Get the modal
var modal8 = document.getElementById('myModal8');
// Get the button that opens the modal
var btn8 = document.getElementById("myBtn8");
// Get the <span> element that closes the modal
var span8 = document.getElementsByClassName("close8")[0];
// When the user clicks the button, open the modal
btn8.onclick = function() {
    modal8.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
span8.onclick = function() {
    modal8.style.display = "none";
}


</script>
