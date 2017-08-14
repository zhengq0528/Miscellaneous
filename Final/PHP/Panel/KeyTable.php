<?php
function displayKeys()
{
  echo"<div class='container'>";
  include('../Database/db.php');
  $codes = array("p","P","t","T","l","L","R","r","M","m","E","e","X","x","S","s");
  $cCode = array("m","M","r","R","l","L");
  $extrakey = array();
  $sql = "SELECT * FROM test.panel WHERE jn = '$_GET[jn]'";
  $result = $conn->query($sql);
  if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
  }
  while ($row = mysqli_fetch_array($result)) {
    //echo "$row[panel] <br>";
    $sql2 = "SELECT * FROM test.circuit WHERE jn = '$_GET[jn]' and panel = '$row[panel]'";
    $result2 = $conn->query($sql2);
    if (!$result2) {
      echo 'Could not run query: ' . mysql_error();
      exit;
    }
    while ($row = mysqli_fetch_array($result2)) {
      $cos = strtoupper($row['code']);
      if(!in_array($row['code'],$codes))
      {
        if(!array_key_exists($row['code'],$extrakey))
        {
          $extrakey[$cos] = 0;
          $sql = "INSERT INTO test.keys(jn,keyname,derating) VALUES ($_GET[jn],'$cos',100)";
          $conn->query($sql);

        }
      }
    }
  }
  if(isset($_POST['sk']))
  {
    if(strcmp($_POST['sk'], "CREATE") == 0)
    {
      $sql = "INSERT INTO test.keys(jn,keyname,derating) VALUES ($_GET[jn],'NEW',100)";
      $conn->query($sql);
    }
    if(strcmp($_POST['sk'], "Delete") == 0)
    {
      $sql = "DELETE FROM test.keys WHERE keyname = '$_POST[kn]'
      and jn = '$_GET[jn]'";
      if(!in_array($_POST['kn'],$codes))
      {
        if ($conn->query($sql) === TRUE) {
        } else
        {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }
      else {
        echo "Can not be Delete! It is a Default Key";
      }
    }
    ?>

    <table style="margin-left:100px;" width = "400" height = "auto" class ="table-bordered table-hover">
      <thead>
        <tr>
          <th width = "70"><center>Key</th>
            <th width = "250"><center>Descriptions</th>
              <th width = "80"><center>Derating</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT * FROM test.keys
              WHERE jn= '$_GET[jn]'";
              $c = -1;
              //var_dump($extrakey);
              $result2 = $conn->query($sql);
              //$keyArray = array();
              while($row = $result2->fetch_assoc()) {
                echo "<tr>";
                if(array_key_exists($row[keyname],$extrakey))
                {
                  CreateKeyCell($row['id'],'keyname',$row['keyname']);
                  CreateKeyCell($row['id'],'description',$row['description']);
                  CreateKeyCellN($row['id'],'derating',$row['derating']);
                }
                else if(!array_key_exists($row[keyname],$extrakey))
                {
                  if(in_array($row[keyname],$codes))
                  {
                    echo "<tr>";
                    echo "<td class = 'constant'><center>$row[keyname]</td>
                    <td class= 'constant'><center>$row[description]</td>";
                    if(in_array($row[keyname],$cCode))
                    {
                      echo "<td class= 'constant'><center>--</td>";
                    }
                    else
                    {
                      CreateKeyCellN($row['id'],'derating',$row['derating']);
                    }
                    echo "</tr>";
                  }
                  else
                  {
                    CreateKeyError($row['id'],'keyname',$row['keyname']);
                    CreateKeyError($row['id'],'description',$row['description']);
                    CreateKeyCellN($row['id'],'derating',$row['derating']);
                  }
                }
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
          <form action='#' form method='post'>
            <input type = "Submit" name="sk" value = "CREATE">
            <br>
            <p> Enter Key Name:
              <input style='text-transform:uppercase' type = "text" name ="kn" value ="">
              To Delete. (NOTE: key name in blue only)
              <input type = "Submit" name="sk" value = "Delete">
            </p>
          </form>
          <?php
        }
        echo "</div>";
      }

      function CreateKeyCellN($id,$type,$value)
      {
        //Get which is which, and importing to javascript.
        //Javascript/Ajax handling with Database. send post to database. and Modifiying it.
        $sid = $type .'_'.$id;
        $tid = $type .'_input_'.$id;
        echo "<td tabindex='0' id=$id class = '$type'><center>";
        echo "<span style='text-transform:uppercase' id=$sid class='text'>$value</span>";
        echo "<input style='text-transform:uppercase' type='number' class = 'editbox' id=$tid value='$value' >";
        echo "%";
        echo  "</td>";
      }
      function CreateKeyCell($id,$type,$value)
      {
        //Get which is which, and importing to javascript.
        //Javascript/Ajax handling with Database. send post to database. and Modifiying it.
        $sid = $type .'_'.$id;
        $tid = $type .'_input_'.$id;
        echo "<td tabindex='0' id=$id class = '$type'><center>";
        echo "<span style='text-transform:uppercase' id=$sid class='text'>$value</span>";
        echo "<input style='text-transform:uppercase' type='text' class = 'editbox' id=$tid value='$value' >";
        echo  "</td>";
      }
      function CreateKeyError($id,$type,$value)
      {
        //Get which is which, and importing to javascript.
        //Javascript/Ajax handling with Database. send post to database. and Modifiying it.
        $sid = $type .'_'.$id;
        $tid = $type .'_input_'.$id;
        echo "<td tabindex='0' id=$id class = '$type'><center>";
        echo "<span style='text-transform:uppercase' style='color:red' id=$sid class='text'>$value</span>";
        echo "<input style='text-transform:uppercase' type='text' class = 'editbox' id=$tid value='$value' >";
        echo  "</td>";
      }
      ?>
