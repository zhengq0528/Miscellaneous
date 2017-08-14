<?php
include('db.php');

function CreateHeader()
{
  echo "<th class = 'th1'><center></th>";
  echo "<th class = 'th2'><center>CIRCUIT USE</th>";
  echo "<th class = 'th3'><center>A</th>";
  echo "<th class = 'th3'><center>LOAD <BR>B</th>";
  echo "<th class = 'th3'><center>C</th>";
  echo "<th class = 'th4'><center>CCT.<BR>NO.</th>";
  echo "<th class = 'th5'><center>CIRCUIT <BR>BREAKER</th>";
  echo "<th class = 'th5'><center>CIRCUIT <BR>BREAKER</th>";
  echo "<th class = 'th4'><center>CCT.<BR>NO.</th>";
  echo "<th class = 'th3'><center>A</th>";
  echo "<th class = 'th3'><center>LOAD <BR>B</th>";
  echo "<th class = 'th3'><center>C</th>";
  echo "<th class = 'th1'><center></th>";
  echo "<th class = 'th2'><center>CIRCUIT USE</th>";
}
//Draw Cell for other keys
function EditHeader($id,$type,$value)
{
  //Get which is which, and importing to javascript.
  //Javascript/Ajax handling with Database. send post to database. and Modifiying it.
  $sid = $type .'_'.$id;
  $tid = $type .'_input_'.$id;
  echo "<p tabindex='0' id=$id class = '$type'><center>";
  echo "<span  id=$sid class='text'>$value</span>";
  echo "<input  type='text' class = 'editbox' id=$tid value='$value' >";
  echo  "</p>";
}
function HeaderInfo($panelName,$Location,$PhaseA1,$PhaseB1,$PhaseC1,$Service,$mounting,$ShortCircuitRating,$NeutralBus,$MainBreaker,$GroundBus,$R,$L)
{
  echo "<div class='divTableCell'>";
  echo "<h5 style='width: 245px; display: table;'>";
  echo "<span style='display: table-cell; width:75px;'>LOCATION:</span>";
  echo "<span id = 'location' style='display: table-cell; border-bottom: 1px solid black;'><center>$Location</span>";
  echo "</h5>";
  echo "<h5 style='width: 245px; display: table;'>";
  echo "<span style='display: table-cell; width:75px;'>SERVICE:</span>";
  echo "<span style='display: table-cell; border-bottom: 1px solid black;'><center>$Service</span>";
  echo "</h5>";
  echo "<h5 style='width: 245px; display: table;'>";
  echo "<span style='display: table-cell; width:75px;'>MAIN BREAKER:</span>";
  echo "<span style='display: table-cell; border-bottom: 1px solid black;'><center>$MainBreaker</span>";
  echo "</h5>";
  echo "<h5 style='width: 245px; display: table;'>";
  echo "<span style='display: table-cell; width:75px;'>MAIN LUGS:</span>";
  echo "<span style='display: table-cell; border-bottom: 1px solid black;'><center>$Location</span>";
  echo "</h5>";
  echo "<h5 style='width: 245px; display: table;'>";
  echo "<span style='display: table-cell; width:75px;'>NEUTRALBUS:</span>";
  echo "<span style='display: table-cell; border-bottom: 1px solid black;'><center>$NeutralBus</span>";
  echo "</h5>";
  echo "<h5 style='width: 245px; display: table;'>";
  echo "<span style='display: table-cell; width:75px;'>GROUNDBUS:</span>";
  echo "<span style='display: table-cell; border-bottom: 1px solid black;'><center>$GroundBus</span>";
  echo "</h5>";
  echo "<h5 style='width: 245px; display: table;'>";
  echo "<span style='display: table-cell; width:75px;'>SHORT CIRCUIT RATING:</span>";
  echo "<span style='display: table-cell; border-bottom: 1px solid black;'><center>$ShortCircuitRating</span>";
  echo "</h5>";
  echo "<input type ='hidden' id = pn value = $panelName></input>";
  echo "<button onclick='editHeader()'>Edit</button>";
  echo"</div>";

  echo "<div class='divTableCell'>";
  echo "<h5 style='width: 245px; display: table;'>";
  echo "<span style='display: table-cell; width:75px;'>PHASE A:</span>";
  echo "<span style='display: table-cell; border-bottom: 1px solid black;'><center>$PhaseA1 VA CL</span>";
  echo "</h5>";
  echo "<h5 style='width: 245px; display: table;'>";
  echo "<span style='display: table-cell; width:75px;'>PHASE B:</span>";
  echo "<span style='display: table-cell; border-bottom: 1px solid black;'><center>$PhaseB1 VA CL</span>";
  echo "</h5>";
  echo "<h5 style='width: 245px; display: table;'>";
  echo "<span style='display: table-cell; width:75px;'>PHASE C:</span>";
  echo "<span style='display: table-cell; border-bottom: 1px solid black;'><center>$PhaseC1 VA CL</span>";
  echo "</h5>";
  $total = $PhaseA1 + $PhaseB1 + $PhaseC1;
  echo "<h5 style='width: 245px; display: table;'>";
  echo "<span style='display: table-cell; width:75px;'>TOTAL:</span>";
  echo "<span style='display: table-cell; border-bottom: 1px solid black;'><center>$total VA CL</span>";
  echo "</h5>";
  echo"</div>";
  echo "<div class='divTableCell'>";
  echo "<h5 style='width: 245px; display: table;'>";
  echo "<span style='display: table-cell; width:75px;'>PHASE A:</span>";
  echo "<span style='display: table-cell; border-bottom: 1px solid black;'><center>$PhaseA2 KVA DL</span>";
  echo "</h5>";
    echo"</div>";
  echo " <div class='divTableCell'>";
  echo "<h5 style='width: 245px; display: table;'>";
  echo "<span style='display: table-cell; width:75px;'>L:LIGHTING</span>";
  echo "<span style='display: table-cell; border-bottom: 1px solid black;'><center>$L KVA</span>";
  echo "</h5>";

  echo "<h5 style='width: 245px; display: table;'>";
  echo "<span style='display: table-cell; width:75px;'>R:RECEPTACLES</span>";
  echo "<span style='display: table-cell; border-bottom: 1px solid black;'><center>$R KVA</span>";
  echo "</h5>";
  echo"</div>";
}

function CreateBottom($suma1,$sumb1,$sumc1,$suma2,$sumb2,$sumc2){
  ?>
  <th> </th>
  <th>SUBTOTALS</th>
  <th><center><?php echo $suma1; ?></th>
  <th><center><?php echo $sumb1; ?></th>
  <th><center><?php echo $sumc1; ?></th>
  <th><center></th>
  <th><center></th>

  <th><center></th>
  <th><center></th>
  <th><center><?php echo $suma2; ?></th>
  <th><center><?php echo $sumb2; ?></th>
  <th><center><?php echo $sumc2; ?></th>
  <th><center></th>
  <th>SUBTOTALS</th>
  <?php
}
?>
