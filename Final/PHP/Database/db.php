
<?php
//Database, it is a temperate database connection
  $mysql_hostname = 'localhost';
  $mysql_user = 'root';
  $mysql_password = 'bard$rover';
  $mysql_database = "Dickerson Engineer";
  $conn = new mysqli($mysql_hostname, $mysql_user,$mysql_password);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

?>
