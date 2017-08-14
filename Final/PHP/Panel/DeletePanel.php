<?php
if(isset($_POST['deletePanel'])){
  $pname = $_POST['deletePanel'];

  $JNDirs = 'Y://Project/'.$_GET['jn'];
  $Files = $JNDirs."//JSONPanel//".$pname.".json";
  //echo "unlinking $Files";
  unlink($Files);

  $sql = "DELETE FROM test.panel
  WHERE jn = $_GET[jn] and panel = '".$pname."'";

  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error deleting record: " . $conn->error;
  }
  $sql = "DELETE FROM test.circuit WHERE jn = '$_GET[jn]' and panel = '".$pname."'";

  if ($conn->query($sql) === TRUE) {
    //echo "Record deleted successfully";
  } else {
    echo "Error deleting record: " . $conn->error;
  }

  $sql3 = "DELETE From test.transformer
  WHERE jn=$_GET[jn] and source = '".$pname."'";
  if ($conn->query($sql3) === TRUE) {
  } else {
    echo "Error deleting record: " . $conn->error;
  }
}
?>
