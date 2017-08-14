<div class='container'>
  <script src="../../JavaScript/PanelTableOnTouch.js?v=2" type="text/javascript"></script>
  <?php
  echo "<h1>PANEL DATA SCHEDULE &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
  PANEL NAME: $panelName <br></h1>";
  //HeaderInfo2($row);
  echo "<h5 style='width: 1050px; display: table;'>";
  echo "<span style='display: table-cell; width:50px;' id ='type' value='lol'>Note:</span>";
  echo "<span style='display: table-cell; border-bottom: 1px solid black;'>$row[notes]</span>";
  echo "</h5>";
  include('../Buttoms/IsoUpdate.php');

  // table-striped
  ?>
  <table class ="table table-bordered table-hover" id = "mydata">
    <thead> <tr> <?php CreateHeader2(); ?> </tr> </thead>
    <tbody> <?php
    $suma1 = 0;  $sumb1 = 0;  $sumc1 = 0;  $suma2 = 0;  $sumb2 = 0;  $sumc2 = 0;
    $sql = "SELECT * FROM test.circuit
    WHERE jn = '$_GET[jn]' and panel = '".$panelName."'";
    $result = $conn->query($sql);
    $codes = array('T','t','P','p');
    while($row = $result->fetch_assoc()){
      $id = $row['id']; $bftype =$row['bftype']; $circuit = $row['circuit']; $code = $row['code'];
      $watts3 = $row['watts3']; $watts2 = $row['watts2']; $watts1 = $row['watts1']; $uses = $row['uses'];
      if($circuit % 2 != 0)
      {
        $suma1 += $watts1; $sumb1 += $watts2; $sumc1 += $watts3;
        CreateTabelCell($id,'code',$code);
        CreateTabelCell($id,'uses',$uses);
        CreateTabelCell($id,'watts1',$watts1);
        echo "<td class = 'constant'><center>$row[circuit]</td>";
        CreateTabelCell($id,'bftype',$bftype);
      }
      else
      {
        $suma2 += $watts1; $sumb2 += $watts2; $sumc2 += $watts3;
        CreateTabelCell($id,'bftype',$bftype);
        echo "<td class = 'constant'><center>$row[circuit]</td>";
        CreateTabelCell($id,'watts1',$watts1);
        CreateTabelCell($id,"code",$code);
        CreateTabelCell($id,"uses",$uses);
        echo "</tr>";
      }
    }
    ?></tbody>
    <tfood>
      <tr>
        <?php CreateBottom2($suma1,$sumb1,$sumc1,$suma2,$sumb2,$sumc2); ?>
      </tr>
    </tfood>
  </table>
</div>
<script>
$('#mydata').dataTable(
  {
    "order": [[ 6, "desc" ]],
    "bSort" : false,
    "iDisplayLength": 100,
    "sDom": "t",
    columnDefs: [
      { width: 20,targets: 0 },
      { width: 250, targets: 1 },
      { width: 50, targets: 2 },
      { width: 10, targets: 3 },
      { width: 70, targets: 4 },

      { width: 70, targets: 5 },
      { width: 10, targets: 6 },
      { width: 50, targets: 7 },
      { width: 20, targets: 8 },
      { width: 250, targets: 9 },
    ],
    select: {
      style:    'os',
      selector: 'td:first-child'
    },
  }
);
</script>
