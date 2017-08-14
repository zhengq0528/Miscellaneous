<?php
include("../Database/db.php");
if($_POST['id'])
{

 //var dataString = 'id='+ id +'&jn='+Jnum+'&host='+host+'$pn'+pn;
  //echo $_POST['id']."is here";
  $id = $_POST['id'];
  $jn = $_POST['jn'];
  $pns = $_POST['ppns'];
  $host = $_POST['host'];

  $File = "Y://Project//Quan.txt";
  $dirname = dirname();
  $f = @fopen($File, "r+");
  ftruncate($f, 0);
  fclose($f);
  $myfile = fopen($File, "w") or die("Unable to open file!");
  $txt = "id : $id
          jn : $jn
          panel : $pns
          host : $host
    Date: ".date("Y-m-d")."; Time is : ".date("h:i:sa");
  fwrite($myfile, $txt);
  fclose($myfile);
  $time = date("Y-m-d").date("h:i:sa");
  $sql = "UPDATE test.tracklog SET times='$time', state ='1' where id ='$id'";
  //$sql = "UPDATE test.tracklog(state,times)
  //  VALUES('$jn','$host','1','$panelName','$hostname is editing')";
  if($conn->query($sql))
  {
    echo "good to go";
  }
  /*
  $sql = "UPDATE test.transformer SET $type = '$key' WHERE id = '$id' ";
  echo "$id is here <br>";
  if(mysqli_query($conn,$sql)){
    echo " <br>Records were updated successfully.";
  }
  else {
    echo " <br>ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }
  */
}
?>
