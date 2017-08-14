<head>
<style>
/* Dis connect a panel or transformet.*/
.modal4 {
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
.modal-content4 {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}
/* The Close Button */
.close4 {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}
.close4:hover,
.close4:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
</head>
<?php
?>
<!-- Trigger/Open The Modal -->
<button id="myBtn4">Disconnect Panel</button>
<!-- The Modal -->
<div id="myModal4" class="modal4">
  <!-- Modal content -->
  <div class="modal-content4">
    <span class="close4">&times;</span>
    <H3>Click a Panel to Disconnect!</h3>
      <?php
      include('../Database/db.php');
      $sql = "SELECT * FROM test.circuit
      WHERE jn = '$_GET[jn]' AND panel = '".$panelName."'";
      $result = $conn->query($sql);
      $codes = array('P','p','T','t','1','4');
      echo "<form method='post'>";
      echo "<input type='hidden' value= $panelName name = 'panel'>";
      echo "<input type='hidden' value= '2' name = 'redo'>";
      echo "<input type= hidden name = 'tp' value = '$type'>";
      while($row = $result->fetch_assoc()) {
        if(in_array($row['linkphase'],$codes))
        {
          echo " <input style='height:35px;width:40px;' type='submit' value= $row[circuit] name = 'ShowTable'> ";
        }
      }
      ?>
    </div>
  </div>

  <script>
  // Get the modal
  var modal4 = document.getElementById('myModal4');
  // Get the button that opens the modal
  var btn4 = document.getElementById("myBtn4");
  // Get the <span> element that closes the modal
  var span4 = document.getElementsByClassName("close4")[0];
  // When the user clicks the button, open the modal
  btn4.onclick = function() {
    modal4.style.display = "block";
  }
  // When the user clicks on <span> (x), close the modal
  span4.onclick = function() {
    modal4.style.display = "none";
  }

  </script>
