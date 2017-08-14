<?php
error_reporting(0);
$SpecialCode = array('OFF','CMU','HOL','MSC','PSL','SIC','SMT','VAC');
$mysql_hostname = 'localhost';
$mysql_user = 'root';
$mysql_password = 'bard$rover';
$mysql_database = "Dickerson Engineer";
$conn = new mysqli($mysql_hostname, $mysql_user,$mysql_password);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
include("TimeCard/PHP/ODBC.php");

error_reporting(0);
//Generate the job cal
$dbb = odbc_connect("job_sheet","","") or die("Cannot connect to database\n".odbc_errormsg());
$sql = 'SELECT * FROM JobCal as a LEFT JOIN Jobs AS b ON b.Jn = a.Jn WHERE b.Jn IS NULL';
$result1 = odbc_exec($dbb,$sql);
$jobcal ="
Job System Calendar Check:
";
while ($row = odbc_fetch_array($result1)) {
  $jobcal .="$row[Jn] $row[Engineer] $row[Description] $row[Phase] $row[Due] $row[Engofrecord]\n";
}
echo "$jobcal";

$SpecialCode = array('OFF','CMU','HOL','MSC','PSL','SIC','SMT','VAC');
$mysql_hostname = 'localhost';
$mysql_user = 'root';
$mysql_password = 'bard$rover';
$mysql_database = "Dickerson Engineer";

$conn = new mysqli($mysql_hostname, $mysql_user,$mysql_password);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$employee = array();
$emails = array();
$e_hour = array();
$today = date('d');$month = date('m');$year = date('y'); $monthM= date('M');
$In_Today = "20".date('y')."-$month-$today";
//Get scheduler
//$Tss = $today - 1;
//$Tss = sprintf("%02d", $Tss);
$Yester = date('m/d/y',strtotime("-1 days"));
$scheduletxt = "Scheduled events for $monthM $today,20$year:\n\nStart     Return    Employee  In/Out  Description\n".
"========  ========  ========  ======  ==============\n";
//Get Individual daily hours
$totaltxt = "Employee                   Hours Recorded                        Date: $Yester\n";
$totaltxt .="===================        ==============\n";
//Generate detail of job numbers
$HList = "$jobcal \n Complete Time List:\n\n";
$sql = 'SELECT * FROM tc.employee order by Employee';
$result = $conn->query($sql);
while($row = $result->fetch_assoc())
{
  $row['First_name']= ucfirst(strtolower($row['First_name']));
  $row['Last_name']= ucfirst(strtolower($row['Last_name']));
  $employee[$row['Employee']] = "$row[First_name] $row[Last_name]";
  $emails[$row['Employee']] = "$row[First_name].$row[Last_name]@dei-pe.com";
  $e_hour[$row['Employee']] = 0;
}
foreach ($employee as $k => $v) {
  //$v = ucfirst(strtolower($v));
  $v = sprintf("%-26s",$v);
  $sql = "SELECT * FROM time.tsdata WHERE employee = '$k' and date = '$Yester' order by jn";
  $result = $conn->query($sql);
  $c = 0; $c1 = 0;
  while($row = $result->fetch_assoc())
  {
    $c += $row['hours'];
    if(!in_array($row['jn'],$SpecialCode) && !empty($row['jn']))
    {
      $row['employee']= sprintf("%-5s",$row['employee']);
      $row["jn"]= sprintf("%-11s",$row["jn"]);
      $row["project"]= sprintf("%-55s",$row["project"]);
      $row["code"]= sprintf("%-10s",$row["code"]);
      $HList .= "$row[employee] $row[jn] $row[project] $row[code] ".number_format($row['hours'], 1)."\n";
      $c1++;
    }
  }
  if($c1 > 0)
  {
    $HList.= "\n";
  }

  if($c == 0)
  {
    $sqls = "SELECT * FROM time.tsdata WHERE employee = '$k'";
    $results = $conn->query($sqls);
    $cs = 0;
    while($rows = $results->fetch_assoc()){
      $cs += $rows['hours'];
    }
    if($cs == 0) $today_date = "ON TIME CARD";
    else $today_date = "FOR $Yester ";
    $totaltxt .="$v NO TIME $today_date\n";
  }
  else
  {
    $c = number_format($c, 1, '.', '');
    $totaltxt .="$v       $c\n";
  }
}

$sql = "SELECT * FROM schedule.schedule WHERE DATE = '$In_Today' ORDER BY 'Departure Time'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
  $Start = $row['Departure Time'];
  $Start = date('h:i a',strtotime($Start));
  $Returns = $row['Return Time'];
  $Returns = date('h:i a',strtotime($Returns));
  if(empty($row['Departure Time'])) $Start = "";
  if(empty($row['Return Time'])) $Returns = "";
  $Start = sprintf("%-8s",$Start);
  $Returns = sprintf("%-9s",$Returns);
  $row['Employee']= sprintf("%-10s",$row['Employee']);
  $row["Location"]= sprintf("%-6s",$row["Location"]);
  $row["Description"]= sprintf("%-20s",$row["Description"]);
  $scheduletxt .= "$Start  $Returns $row[Employee] $row[Location] $row[Description]\n";
}
$scheduletxt .= "\n";
echo $totaltxt;
echo $scheduletxt;
echo $HList;
//Sample Code for Sending Basic Email
function GenerateRaw($Name,$Sender,$Receiver,$Subject,$Data)
{
  //Where you building the email
  $rawaddr = "M://mdaemon//RAWFILES/$Name.raw";
  $rawlck = "M://mdaemon//RAWFILES/$Name.lck";
  $mklok = fopen($rawlck,"w") or die ("Unable to open file!");
  $mkfile = fopen($rawaddr,"w") or die ("Unable to open file!");
  fwrite($mkfile, "From <$Sender>\n");
  fwrite($mkfile, "To <$Receiver>\n");
  fwrite($mkfile, "Subject <$Subject>\n");
  fwrite($mkfile, "\n");
  fwrite($mkfile, "$Data\n");
  fclose($mkfile);
  fclose($mklok);
  unlink($rawlck);
}

$Name = "Quan";
$Sender   = "jay.tolbert@dei-pe.com";
$Receiver = "Quan.Zheng@dei-pe.com,jay.tolbert@dei-pe.com";

//Send message about quarterly taxes due
if(($today == 15 || $today== 25)
&&($month == 1 || $month ==4 || $month == 7 || $month == 10))
{
  $Name = "quarttax";
  //$Receiver = "jay.tolbert@dei-pe.com,davis.dickerson@dei-pe.com,rick.sabatello@dei-pe.com";
  $Subject = "Quarterly Taxes Due Soon";
  $data = "Quarterly Payroll taxes are due the last day of January, April, July, and October for the prior quarter.
  Our accountant should have sent us the necessary paperwork to file.
  Please verify we have received this and the taxes have been filed.";
  GenerateRaw($Name,$Sender,$Receiver,$Subject,$data);
  echo "Quarterly Tax Notification sent";
}

//Send messages about annual taxes due soon
if(($today == 1||$today ==10)&&$month ==3)
{
  $Name = "AnnualTax";
  //$Receiver = "jay.tolbert@dei-pe.com,davis.dickerson@dei-pe.com,rick.sabatello@dei-pe.com";
  $Subject = "Yearly Taxes Due Soon";
  $data = "Corporate annual tax returns must be filed by March 15th.
  Our accountant should have sent us the necessary paperwork to file.
  Please verify these taxes have been filed.";
  GenerateRaw($Name,$Sender,$Receiver,$Subject,$data);
  echo "Annual Tax Notification sent";
}

//send message about scheduling a pickup for the account information
if($today==2)
{
  $Name = "pickup";
  //$Receiver = "jay.tolbert@dei-pe.com,davis.dickerson@dei-pe.com,rick.sabatello@dei-pe.com";
  $Subject = "Accounting Pickup";
  $data =
  "It's about time to schedule an accounting pickup.\n
  After preparing the information contact them at(847)297-0300 to schedule a pickup, messenger the envelope, or drop it off.";
  GenerateRaw($Name,$Sender,$Receiver,$Subject,$data);
  echo "pickup account information Notification sent";
}

//send messages about estimated taxes document
if(($today==1||$today==10)&&($month==1||$month==4||$month==6||$month==9))
{
  $Name = "estimatedtax";
  $Subject = "Estimated Taxes Due Soon";
  $data = "Estimated taxes are due the 15th (or next business day) of January, April, June, and September.";
  GenerateRaw($Name,$Sender,$Receiver,$Subject,$data);
  echo "estimated tax Notification sent";
}

//send messages to make transaction in Wachovia Accounts
if(($today==1)&&($month == 1 || $month == 4 || $month == 7 || $month == 10))
{
  $Name = "transasction";
  $Subject = "Make Wells Fargo and 5th3rd Transactions";
  $data = "In order not to incur account maintenance charges we need to create a transaction on our Wells Fargo and 5th3rd accounts every 6 months.";
  $data .="This notice is sent at the start of each quarter.  Typically we should transfer $100 from the checking to the money market account for Wells Fargo and move some money to or from Chase for the 5th3rd account.";
  GenerateRaw($Name,$Sender,$Receiver,$Subject,$data);
  echo "estimated tax Notification sent";
}

//send messages to make transaction in Wachovia Account
if($today==1&&$month == 4)
{
  $Name = "professionalday";
  $Subject = "Administrative Professionals Day is Coming";
  $data = "Administrative Professionals Day is the Wednesday of the last full week of April (April 21-27).  You should contact Lyndi to get baskets or plan something else.";
  GenerateRaw($Name,$Sender,$Receiver,$Subject,$data);
  echo "professionalday  Notification sent";
}

//Use taxes due this month
if(($today == 1 || $today== 15)
&&($month == 1 || $month ==4 || $month == 7 || $month == 10))
{
  $Name = "usetax";
  $Subject = "Use Taxes Due this month";
  $data = "Use taxes are due by 20th or next business day of this month.  Get the taxes on the out of state purchases from the prior three months of Amex/Chase statements and file online.";
  GenerateRaw($Name,$Sender,$Receiver,$Subject,$data);
  echo "use tax Notification sent";
}

//echo "20$year$month$Tss \n";
$spts = date('ymd',strtotime("-1 days"));
$Name = "Stats";
$Subject = "Yesterday's Mail Statistics";
$data = "Yesterday's mail stats are at:\n\n";
$data .="https://www.dei-pe.com/mailstats/mailstat.php?date=20$spts";
GenerateRaw($Name,$Sender,$Receiver,$Subject,$data);
echo "Yesterday's mail sent";

//Checking if TMP file exist in tnef_fix files
$dir    = '//MAIL//ddrive//TNEF_FIX//';
$files1 = scandir($dir);$c = 0; $tmp = ":";
for($i = 0; $i < count($files1);$i++){
  if(strpos($files1[$i],'.tmp')==true){
    $tmp .= $files1[$i]."\n";
    $c++;
  }
}
if($c > 0){
  //send messages to make transaction in Wachovia Accounts
  $Name = "checktmp";
  $Subject = "Temporary directories in M://TNEF_FIX directory>";
  $data = "Found at least one temporary directory in the TNEF_FIX directory \n($tmp).\n  Check it.";
  GenerateRaw($Name,$Sender,$Receiver,$Subject,$data);
  echo "use tax Notification sent";
}

$Name = "log";
$Subject = "Hours Logged on $Yester";
echo $totaltxt;
echo $scheduletxt;
$data = "$totaltxt \n$scheduletxt \n$HList";
GenerateRaw($Name,$Sender,$Receiver,$Subject,$data);
echo "use tax Notification sent";


$Name = "logrc";
$Subject = "Hours Logged on $Yester";
echo $totaltxt;
echo $scheduletxt;
$data = "$totaltxt \n$scheduletxt \n$HList";
GenerateRaw($Name,$Sender,$emails['RS'],$Subject,$data);
echo "use tax Notification sent";

$erray = array();
$tarray = array();
$sql = "SELECT time.tsdata.jn,time.tsdata.project,time.tsdata.code,time.tsdata.hours,time.tsdata.employee,tc.job_name.engineer FROM time.tsdata
LEFT JOIN tc.job_name
ON time.tsdata.jn = tc.job_name.jn WHERE date = '$Yester'  order by tc.job_name.jn";
$result = $conn->query($sql);
//6 11 47 6 5
while($row = $result->fetch_assoc())
{
  if(!empty($row['engineer']))
  {
    $em = sprintf("%-6s", $row['employee']);
    $ej = sprintf("%-11s",$row['jn']);
    $ep = sprintf("%-53s",$row['project']);
    $ec = sprintf("%-7s",$row['code']);
    $eh = sprintf("%-5s",$row['hours']);

    $tarray[$row['engineer']] += $row['hours'];
    $eh = number_format($eh, 1, '.', '');
    $erray[$row['engineer']] .= "$em $ej $ep $ec $eh\n";

  }
}



foreach($erray as $key => $datas){
  $individuals =  sprintf("%-71s", "Engineer: $key ");
  $individuals .= sprintf("%-10s", "Dates $Yester\n");
  $individuals .= sprintf("%-6s", "Emp");
  $individuals .= sprintf("%-13s", "Job #");
  $individuals .= sprintf("%-54s", "Project Description");
  $individuals .= sprintf("%-6s", "Code");
  $individuals .= sprintf("%-5s", " Hours\n\n");
  $a = explode("\n",$datas);
  $c = 0;
  foreach($a as $ks)
  {
    $c++;
    $individuals .= $ks."\n";
    if($c%5 == 0) $individuals .= "\n";
  }
  //$individuals .= $datas;
  $individuals .= sprintf("%85s", "=====\n");
  $tarray[$key] = number_format($tarray[$key], 1, '.', '');
  $individuals .= sprintf("%85s", "$tarray[$key]\n");
  echo $datas;
  if(strcasecmp($key,"RS")==0)
  {

  }
  else
  {
    $Name = "logs$key";
    $Subject = "Daily Time Log for $Yester";
    $data = "$individuals\n$totaltxt \n$scheduletxt ";
    GenerateRaw($Name,$Sender,$emails[$key],$Subject,$data);
    echo "$emails[$key] is here testing \t \t";
    echo "use tax Notification sent";
  }
}

$dbb = odbc_connect("License","","") or die("Cannot connect to database\n".odbc_errormsg());
$sql ="SELECT * FROM license";
$todaycal = date('Y-m-d');
$todaycal = strtotime($todaycal);
$result1 = odbc_exec($dbb,$sql);
$expiredtxt = "The following licenses have expired:\n\n";
$is_sent = 0;
while ($row = odbc_fetch_array($result1)) {
  $expired = $row['Exp_date'];
  $expired = strtotime($expired);
  if($todaycal >= $expired && $row['Active']=='Y' && !empty($expired))
  {
    echo "$row[Exp_date]<br>";
    $daday = date('m-d-y',strtotime($row['Exp_date']));
    if(strcasecmp($row['Type'],'COA') ==0 ||strcasecmp($row['Type'],'TAX') ==0||strcasecmp($row['Type'],'AR') ==0)
    $expiredtxt .= "$row[Type] for $row[State] # $row[Lic_num] expired on $daday \n";
    else
    $expiredtxt .= "$row[First_name] $row[Last_name] for $row[State] # $row[Lic_num] expired on $daday \n";
    $is_sent++;
  }
}
if($is_sent>0)
{
  $Name = "exipired";
  $Subject = "Expired Licences in database";
  echo $expiredtxt;
  GenerateRaw($Name,$Sender,"melissa.edwards@dei-pe.com,sandi.tarpey@dei-pe.com,quan.zheng@dei-pe.com",$Subject,$expiredtxt);
  echo "Expired Licences in database sent";
}
$is_sent=0;
/////Contract make Mail

$contra = "Contract Changes: \n\n";
$oldjn = array();
$dir    = 's:/office/contract/2017';
$files1 = scandir($dir);
$files2 = scandir($dir, 1);
$dirs = array_filter(glob($dir), 'is_dir');
$a = count($files2);
foreach($files2 as $ab)
{
  if(is_dir($dir."/$ab") && $ab[0] != '.')
  {
    $dir2 = $dir."/".$ab;
    $files3 = scandir($dir2, 1);
    foreach($files3 as $abb)
    {
      if($abb[0] != '.')
      {
        $jn = explode("-",$abb);
        if(!in_array($jn[0],$oldjn))
        {
          $sql = "SELECT Jn FROM tc.renjn WHERE Oldjn = '$jn[0]'";
          $result = $conn->query($sql);
          while($row = $result->fetch_assoc()){
            echo "$abb --> $row[Jn]<br>";
            $contra .="$abb --> $row[Jn]\n";
            $is_sent++;
          }
        }
      }
    }
  }
  else if($ab[0] == '.')
  {
  }
  else
  {
    $jn = explode("-",$ab);
    if(!in_array($jn[0],$oldjn))
    {
      $sql = "SELECT Jn FROM tc.renjn WHERE Oldjn = '$jn[0]'";
      $result = $conn->query($sql);
      while($row = $result->fetch_assoc()){
        echo "$ab --> $row[Jn]<br>";
        $contra .="$ab --> $row[Jn]\n";
        $is_sent++;
      }
    }
  }
}
if($is_sent >0)
{
  $Name = "Contra";
  $Subject = "Changed Contract Job Numbers on $Yester";
  echo $contra;
  GenerateRaw($Name,$Sender,"melissa.edwards@dei-pe.com,sandi.tarpey@dei-pe.com,quan.zheng@dei-pe.com",$Subject,$contra);
  echo "Expired Licences in database sent";
}

?>
