<?php

//Create a header for the Datatable If you want to change entire table, you have to change from here
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

function CreateHeader1()
{
  echo "<th class = 'th1'><center></th>";
  echo "<th class = 'th2'><center>CIRCUIT USE</th>";
  echo "<th class = 'th3'><center>L1</th>";
  echo "<th class = 'th3'><center>L2</th>";
  echo "<th class = 'th4'><center>CCT.<BR>NO.</th>";
  echo "<th class = 'th5'><center>CIRCUIT <BR>BREAKER</th>";
  echo "<th class = 'th5'><center>CIRCUIT <BR>BREAKER</th>";
  echo "<th class = 'th4'><center>CCT.<BR>NO.</th>";
  echo "<th class = 'th3'><center>L1</th>";
  echo "<th class = 'th3'><center>L2</th>";
  echo "<th class = 'th1'><center></th>";
  echo "<th class = 'th2'><center>CIRCUIT USE</th>";
}
//for isolation panel
function CreateHeader2()
{
  echo "<th class = 'th1'><center></th>";
  echo "<th class = 'th2'><center>CIRCUIT USE</th>";
  echo "<th class = 'th3'><center>A</th>";
  echo "<th class = 'th4'><center>CCT.<BR>NO.</th>";
  echo "<th class = 'th5'><center>CIRCUIT <BR>BREAKER</th>";
  echo "<th class = 'th5'><center>CIRCUIT <BR>BREAKER</th>";
  echo "<th class = 'th4'><center>CCT.<BR>NO.</th>";
  echo "<th class = 'th3'><center>A</th>";
  echo "<th class = 'th1'><center></th>";
  echo "<th class = 'th2'><center>CIRCUIT USE</th>";
}


function inheader1($type,$value)
{
  //Generate the panel info box, it makes more like old panel schedule system
  echo "<h5 style='width: 245px; display: table;'>";
  echo "<span style='display: table-cell; width:160px;' id ='type' value='lol'>$type:</span>";
  echo "<span  style='display: table-cell; border-bottom: 1px solid black;'><center>$value</span>";
  echo "</h5>";
}
function inheader($type,$value)
{
  //Generate the panel info box, it makes more like old panel schedule system, Different type
  echo "<h5 style='width: 245px; display: table;'>";
  echo "<span style='display: table-cell; width:100px;' id ='type' value='lol'>$type:</span>";
  echo "<span  style='display: table-cell; border-bottom: 1px solid black;'><center>$value</span>";
  echo "</h5>";
}


function calculate($l, $d)
{
  $rtmp = $l['R'];
  $ltmp = $l['L'];
  if($l['R'] > 10000)
  {
    $Rload = 10000;
    $Rrestl = $l['R'] - $Rload;
    $Rrestl = $Rrestl / 2;
    $l['R'] = $Rload + $Rrestl;
  }

  include('../../PHP/Database/db.php');
  $sql2 = "SELECT * FROM test.project WHERE jn ='$_GET[jn]'";
  $result2 = $conn->query($sql2);
  $Prow = mysqli_fetch_array($result2);
  $p_type = $Prow['type'];

  if($p_type == 1)
  {
    if($l['L'] > 3000 && $l['L'] <= 120000)
    {
      $Lload = 3000;
      $Lrestl = $l['L'] - $Lload;
      $Lrestl = $Lrestl * 0.35;
      $l['L'] = $Lload + $Lrestl;
    }
    else if($l['L'] > 120000)
    {
      $Lload = 43950;
      $Lrestl = $l['L'] - 120000;
      $Lrestl = $Lrestl * 0.25;
      $l['L'] = $Lload + $Lrestl;
    }
  }
  else if($p_type ==2)
  {
    if($l['L'] > 50000)
    {
      $Lload = 20000;
      $Lrestl = $l['L'] - 50000;
      $Lrestl = $Lrestl * 0.2;
      $l['L'] = $Lload + $Lrestl;
    }
    else
    {
      $l['L'] = $l['L'] * 0.4;
    }
  }
  else if($p_type ==3)
  {
    if($l['L'] > 20000 && $l['L'] <= 100000)
    {
      $Lload = 20000 * 0.5;
      $Lrestl = $l['L'] - 20000;
      $Lrestl = $Lrestl * 0.4;
      $l['L'] = $Lload + $Lrestl;
    }
    else if($l['L'] > 100000)
    {
      $Lload = 42000;
      $Lrestl = $l['L'] - 100000;
      $Lrestl = $Lrestl * 0.3;
      $l['L'] = $Lload + $Lrestl;
    }
    else
    {
      $l['L'] = $l['L'] * 0.5;
    }
  }
  else if($p_type ==4)
  {
    if($l['L'] > 12500)
    {
      $Lload = 12500;
      $Lrestl = $l['L'] - 12500;
      $Lrestl = $Lrestl * 0.5;
      $l['L'] = $Lload + $Lrestl;
    }
  }
  else
  {
      $ltmp = $l['L'];
  }

  $total2C = ($d[0] + $d[1] +$d[2]);
  $total2 = $total2C - $rtmp -$ltmp;
  $total2 = ($total2 + $l['R'] + $l['L']) / 1000;
  $ratio = $total2 / ($total2C/1000);

  return array($ratio,$total2,$rtmp,$ltmp,$l,$d);
}

//general entire Header info of panel schedule system.
function HeaderInfo($row)
{
  include('../Database/db.php');
  RecursiveCalCulateConnectLoad($row['panel'],$_GET['jn']);
  $ph = get3PHVOLTS( $row['service']);
  $t = CompareType($row['type']);
  echo "<div class='divTableCell'>";
  inheader("Job Number",$_GET['jn']);
  inheader("Service", $row['service']);
  inheader("3PH.VOLT",$ph);
  inheader("Location",$row['location']);
  inheader("Mounting",$row['mounting']);
  inheader("MainBreaker",$row['breaker']);
  inheader("MAIN LUGS:",$row['lug']);
  inheader("GroundBus",$row['groundbus']);
  inheader1("Short Circuit Rating",$row['rating']);
  echo"</div>";

  echo "<div class='divTableCell'>";
  $l = RecursiveCalCulateConnectLoad($row['panel'],$_GET['jn']);
  $PhaseA1 = $l[0] / 1000;$PhaseB1 = $l[1] / 1000;$PhaseC1 = $l[2] / 1000;
  echo "<h3><Center>CONNECTED LOAD</h3> <br>";
  inheader("PHASE A",number_format((float)($PhaseA1),2,'.','')." kVA");
  inheader("PHASE B",number_format((float)($PhaseB1),2,'.','')." kVA");
  inheader("PHASE C",number_format((float)($PhaseC1),2,'.','')." kVA");
  $total = $PhaseA1 + $PhaseB1 + $PhaseC1;
  echo "<h5 style='width: 245px; display: table;'>";
  inheader("TOTAL",number_format((float)($total),2,'.','')." kVA");
  if($t == 1)
  $totalA =($total*1000)/($ph);
  else
  $totalA =($total*1000)/(sqrt(3)*$ph);
  inheader("SYM: ",number_format((float)($totalA),1,'.','')." AMPS");
  echo"</div>";
  $d=RecursiveTL($row['panel'],$_GET['jn']);

  $dataes = calculate($l[3],$d);
  $ratio = $dataes[0];
  $total2 = $dataes[1];
  $rtmp = $dataes[2];
  $ltmp = $dataes[3];
  $l[3] = $dataes[4];
  echo "<div class='divTableCell'>";
  echo "<h3><Center>DEMAND LOAD</h3> <br>";
  inheader("PHASE A",number_format((float)(($d[0]/1000)*$ratio),2,'.','')." kVA");
  inheader("PHASE B",number_format((float)(($d[1]/1000)*$ratio),2,'.','')." kVA");
  inheader("PHASE C",number_format((float)(($d[2]/1000)*$ratio),2,'.','')." kVA");

  echo "<h5 style='width: 245px; display: table;'>";
  inheader("TOTAL",number_format((float)($total2),2,'.','')." kVA");
  if($t == 1)
    $totalA =($total2*1000)/($ph);
  else
    $totalA =($total2*1000)/(sqrt(3)*$ph);
  inheader("SYM: ",number_format((float)($totalA),1,'.','')." AMPS");
  echo"</div>";

  //Generate Key array for header and user if job exist
  //It including the derating and Descriptions
  $keys = array();
  $keyDerating = array();
  $sql2 = "SELECT * FROM test.keys WHERE jn ='$_GET[jn]'";
  $result1 = $conn->query($sql2);
  while($row = mysqli_fetch_array($result1))
  {
    $keys +=[strtoupper($row['keyname']) => $row['description']];
    $keyDerating +=[strtoupper($row['keyname']) => $row['derating']];
  }

  echo " <div class='divTableCell'>";
  echo "<h3><Center>KEYS</h3> <br>";
    echo "  &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  Conn Load | Dema Load";
  foreach($l[3] as $key => $value) {
    if(strcmp($key,"L")==0)
    {
      inheader("[$key] $keys[$key]",number_format((float)($ltmp/1000),2,'.','')." kVA|". number_format((float)($value/1000),2,'.','')."kVA");
    }
    else if(strcmp($key,"R")==0)
    {
      inheader("[$key] $keys[$key]",number_format((float)($rtmp/1000),2,'.','')." kVA|". number_format((float)($value/1000),2,'.','')."kVA");
    }
    else
    {
      inheader("[$key] $keys[$key]",number_format((float)($value/1000),2,'.','')." kVA|". number_format((float)(($value*($keyDerating[$key]/100))/1000),2,'.','')."kVA");
    }
  }
  echo"</div>";
}

//general entire Header info of panel schedule system.
function HeaderInfo2($row)
{
  include('../Database/db.php');
  RecursiveCalCulateConnectLoad($row['panel'],$_GET['jn']);
  $ph = get3PHVOLTS( $row['service']);
  $t = CompareType($row['type']);
  echo "<div class='divTableCell'>";
  inheader("Job Number",$_GET['jn']);
  inheader("Service", $row['service']);
  inheader("3PH.VOLT",$ph);
  inheader("Location",$row['location']);
  inheader("Mounting",$row['mounting']);
  inheader("GroundBus",$row['groundbus']);
  inheader("MainBreaker",$row['breaker']);
  inheader("MAIN LUGS:",$row['lug']);
  inheader1("Short Circuit Rating",$row['rating']);
  echo"</div>";

  echo "<div class='divTableCell'>";
  $l = RecursiveCalCulateConnectLoad($row['panel'],$_GET['jn']);
  $PhaseA1 = $l[0] / 1000;$PhaseB1 = $l[1] / 1000;$PhaseC1 = $l[2] / 1000;
  echo "<h3><Center>CONNECTED LOAD</h3> <br>";
  inheader("PHASE A",number_format((float)($PhaseA1/2),2,'.','')." kVA");
  inheader("PHASE B",number_format((float)($PhaseA1/2),2,'.','')." kVA");

  $total = $PhaseA1;
  echo "<h5 style='width: 245px; display: table;'>";
  inheader("TOTAL",number_format((float)($total),2,'.','')." kVA");
  if($t == 1)
  $totalA =($total*1000)/($ph);
  else
  $totalA =($total*1000)/(sqrt(3)*$ph);
  inheader("SYM: ",number_format((float)($totalA),1,'.','')." AMPS");
  inheader1("TRANSFORMER SIZE:",$row['neutralbus']);
  inheader1("SECONDARY VOLTAGE:",$row['aicrating']);
  echo"</div>";

  echo "<div class='divTableCell'>";
  $d=RecursiveTL($row['panel'],$_GET['jn']);
  echo "<h3><Center>DEMAND LOAD</h3> <br>";
  inheader("PHASE A",number_format((float)($d[0]/2000),2,'.','')." kVA");
  inheader("PHASE B",number_format((float)($d[0]/2000),2,'.','')." kVA");
  $total2 = ($d[0]) / 1000;
  echo "<h5 style='width: 245px; display: table;'>";
  inheader("TOTAL",number_format((float)($total2),2,'.','')." kVA");
  if($t == 1)
    $totalA =($total2*1000)/($ph);
  else
    $totalA =($total2*1000)/(sqrt(3)*$ph);
  inheader("SYM: ",number_format((float)($totalA),1,'.','')." AMPS");
  inheader1("LINE ISOLATION MONITOR:",$row['groundbus']);
  echo"</div>";

  //Generate Key array for header and user if job exist
  //It including the derating and Descriptions
  $keys = array();
  $keyDerating = array();
  $sql2 = "SELECT * FROM test.keys WHERE jn ='$_GET[jn]'";
  $result1 = $conn->query($sql2);
  while($row = mysqli_fetch_array($result1))
  {
    $keys +=[strtoupper($row['keyname']) => $row['description']];
    $keyDerating +=[strtoupper($row['keyname']) => $row['derating']];
  }

  echo " <div class='divTableCell'>";
  echo "<h3><Center>KEYS</h3> <br>";
  foreach($l[3] as $key => $value) {
    inheader("[$key] $keys[$key]",number_format((float)($value/1000),2,'.','')." kVA | $keyDerating[$key] %");
  }
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
function CreateBottom1($suma1,$sumb1,$sumc1,$suma2,$sumb2,$sumc2)
{
?>
<th> </th>
<th>SUBTOTALS</th>
<th><center><?php echo $suma1; ?></th>
<th><center><?php echo $sumb1; ?></th>

<th><center></th>
<th><center></th>

<th><center></th>
<th><center></th>
<th><center><?php echo $suma2; ?></th>
<th><center><?php echo $sumb2; ?></th>
<th><center></th>
<th>SUBTOTALS</th>
<?php
}
function CreateBottom2($suma1,$sumb1,$sumc1,$suma2,$sumb2,$sumc2)
{
  ?>
  <th> </th>
  <th>SUBTOTALS</th>
  <th><center><?php echo $suma1; ?></th>

  <th><center></th>
  <th><center></th>

  <th><center></th>
  <th><center></th>
  <th><center><?php echo $suma2; ?></th>
  <th><center></th>
  <th>SUBTOTALS</th>
  <?php
}
?>
