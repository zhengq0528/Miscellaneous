<?php
function CreateTranCell($id,$type,$value)
{
  //Get which is which, and importing to javascript.
  //Javascript/Ajax handling with Database. send post to database. and Modifiying it.
  $sid = $type .'_'.$id;
  $tid = $type .'_input_'.$id;
  echo "<td tabindex='0' id=$id class = '$type'><center>";
  echo "<span id=$sid class='text'>$value</span>";
  echo "<input  type='text' class = 'editbox' id=$tid value='$value' >";
  echo  "</td>";
}
if(isset($_POST['tf']))
{
  echo"<div class='container'>";
  ?>
  <h2 style="margin-left:300px;">Transformer Schedule</h2>
  <table style="margin-left:100px;" width = "800" height = "auto" class ="table-bordered table-hover">
    <thead>
      <tr>
          <th width = "70"><center>TRANSF.NO.</th>
          <th width = "50"><center>KVA</th>
          <th width = "80"><center>SOURCE</th>
          <th width = "80"><center>PRIMARY<BR>VOLTS</th>
          <th width = "80"><center>DESTINATION</th>
          <th width = "80"><center>SECONDARY<BR>VOLTS</th>
          <th width = "60"><center>GRND WIRE<BR>APPVD GRND</th>
          <th><center>REMARKS</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * from test.transformer WHERE jn = $_GET[jn]";
          $result = $conn->query($sql);
          while($row = mysqli_fetch_array($result))
          {
            echo "<tr>";
            echo "<td class = 'constant'><center>$row[name]</td>";
            CreateTranCell($row['id'],'rating',$row['rating']);
            //echo "<td class = 'constant'><center>$row[rating]</td>";
            echo "<td class = 'constant'><center>$row[source]</td>";
            $result1 = $conn->query("SELECT service FROM test.panel
              WHERE panel = '$row[source]' and jn = '$_GET[jn]'");
            $rows = mysqli_fetch_array($result1);
            echo "<td class = 'constant'><center>".get3PHVOLTS($rows[service])."</td>";
            echo "<td class = 'constant'><center>$row[destination]</td>";
            $result2 = $conn->query("SELECT service FROM test.panel
              WHERE panel = '$row[destination]' and jn = '$row[djn]'");
            $rows = mysqli_fetch_array($result2);
            echo "<td class = 'constant'><center>".get3PHVOLTS($rows[service])."</td>";
            echo "<td class = 'constant'><center>NA</td>";
            CreateTranCell($row['id'],'remark',$row['remark']);
            //CreateKeyCell($row['id'],'derating',$row['derating']);
            echo "</tr>";
          }
           ?>
        </tbody>
      </table>
  <?php
  echo "</div>";
}
?>
