<head>
<style>
/* Delete the existing panels.
   You can add more conditions here when you are deteting the panel*/
.modal22 {
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
.modal-content22 {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}
/* The Close Button */
.close22 {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
.close22:hover,
.close22:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>
</head>
<?php
?>
<!-- Trigger/Open The Modal -->
<!-- The Modal -->
<div id="myModal22" class="modal22">  <!-- Modal content -->
  <div class="modal-content22">
    <center>
    <?php
    $hname = str_replace(".dei-pe.com","",$row['user']);
    $hname = str_replace("pc-","",$hname);
    $hname = str_replace("PC-","",$hname);
    $hname = strtoupper($hname);
    echo "<h1 style='color:red';>USER: <<---$hname--->> IS EDITING THIS PANEL!!!</H1>";
    ?>
  </center>
  </div>
</div>

<script>
var modal22 = document.getElementById('myModal22');
modal22.style.display = "block";
</script>
