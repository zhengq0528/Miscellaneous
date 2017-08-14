<?php
error_reporting(0);

$SpecialCode = array('OFF','CMU','HOL','MSC','PSL','SIC','SMT','VAC','PRE','SU','SP','SIC','CA','CAD','DE',"");
$mysql_hostname = 'localhost';
$mysql_user = 'root';
$mysql_password = 'bard$rover';
$mysql_database = "Dickerson Engineer";
$conn = new mysqli($mysql_hostname, $mysql_user,$mysql_password);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$db = odbc_connect("job_name5","","") or die("Cannot connect to database\n".odbc_errormsg());

//$sql_result = odbc_exec($db, "DELETE FROM `tsmtgs1.DB`;") or die(odbc_errormsg());
/*
$sql = "CREATE TABLE tsmtgs1 (
`JN` TEXT(10),
`PROJECE` TEXT(55),
`CODE` TEXT(5),
`DATE` TEXT(10),
`HOURS` TEXT(10),
`EMPLOYEE` TEXT(2)
);";
*/
//ECHO "DEBUG";
//$res = odbc_exec($db, $sql)or die(odbc_errormsg());

?>
<body> <center>
  <H2>Meeting Scheduler!<br></h2>
    <FORM id= 'form1' method = 'post'>
      <input type='submit' value = 'Generate Meeting Schedule!' name = 'm1'>
    </FORM>
  </body>
  <?php
  if(isset($_POST['m1']))
  {
    $sql = "DELETE FROM time.tsmtgs";
    $result = $conn->query($sql);

    if (file_exists('file.csv')) {
      unlink('file.csv');
    }
    $fp = fopen('file.csv', 'w');

    $sql = "SELECT jn,project,code,date,hours,employee FROM time.tsdata";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc())
    {
      if(!in_array($row['code'],$SpecialCode) && strcmp($row['code'],0)!=0)
      {
        fputcsv($fp, $row);
        $sqls = "INSERT into time.tsmtgs SET jn = '$row[jn]',
        project = '$row[project]',
        code = '$row[code]',
        date = '$row[date]',
        hours = '$row[hours]',
        employee = '$row[employee]'";
        if(!$conn->query($sqls))
        {
          echo $conn->error;
        }

        $row['jn'] =sprintf("%-10s", $row['jn']);
        $row['project'] =sprintf("%-55s", $row['project']);
        $row['date'] =sprintf("%-10s", $row['date']);
        $row['hours'] =sprintf("%-5s", $row['hours']);
        $row['employee'] =sprintf("%-3s", $row['employee']);
        echo "$row[jn] $row[project] $row[date] $row[hours] $row[employee]<bR>";
      }
    }
    echo "<h3>Successfully Generated Meeting Schedules!</h3>";
    fclose($fp);

  }

  ?>
