<form form method='post'>
  <input  style="height:40px;width:140px" type = "Submit" name="exports" value = "ExportAll">
</form>
<?php
if(isset($_POST['exports']))
{
  $sql = "SELECT panel FROM test.panel WHERE jn = '$_GET[jn]'";
  $result = $conn->query($sql);
  if (!$result) {
    exit;
  }
  $pne = $value['panel'];
  $JNDir = 'Y://Project/'.$_GET['jn'];
  $File = $JNDir."//JSONPanel//panellist.txt";
  $dirname = dirname($File);
  if (!is_dir($dirname))
  {
    mkdir($dirname, 0755, true);
  }
  else{
    $f = @fopen("$File", "r+");
    ftruncate($f, 0);
    fclose($f);
  }
  $myfile = fopen($File, "w") or die("Unable to open file!");

  if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $PN = $row['panel']."
";
        fwrite($myfile, $PN);

    }

    //exportdata($a);
}
    fclose($myfile);
}

function exportdata($r)
{
  include('../../PHP/DataTable/GenerateTable.php');
  include('../../PHP/DataTable/LinkPanel.php');
  include('../../PHP/DataTable/TranPanel.php');
  include('../Database/db.php');
  foreach($r as $key => $value)
  {
    //echo "$value[panel]";
    $pne = $value['panel'];
    $JNDir = 'Y://Project/'.$_GET['jn'];
    $File = $JNDir."//JSONPanel//".$pne.".json";
    $dirname = dirname($File);
    if (!is_dir($dirname))
    {
      mkdir($dirname, 0755, true);
    }
    else{
      $f = @fopen("$File", "r+");
      ftruncate($f, 0);
      fclose($f);
    }
    $myfile = fopen($File, "w") or die("Unable to open file!");



    $l = RecursiveCalCulateConnectLoad($pne,$_GET['jn']);
    $d = RecursiveTL($pne,$_GET['jn']);
    $c1 = number_format((float)($l[0]/1000),2,'.','');
    $c2 = number_format((float)($l[1]/1000),2,'.','');
    $c3 = number_format((float)($l[2]/1000),2,'.','');

    $sql = "SELECT * FROM test.panel WHERE panel = '$pne' and jn = '$_GET[jn]'";
    $resultMain = $conn->query($sql);
    $row = mysqli_fetch_array($resultMain);
    $ph = get3PHVOLTSe($row['service']);
    $c = ($l[0] + $l[1] + $l[2])/1000;
    //$d = ($d[0] + $d[1] + $d[2])/1000;
    $dataes = calculate($l[3],$d);
    $ratio = $dataes[0];
    $total2 = $dataes[1];
    $rtmp = $dataes[2];
    $ltmp = $dataes[3];
    $l[3] = $dataes[4];
    $d1 = number_format((float)(($d[0]/1000)*$ratio),2,'.','');
    $d2 = number_format((float)(($d[1]/1000)*$ratio),2,'.','');
    $d3 = number_format((float)(($d[2]/1000)*$ratio),2,'.','');

    $d = number_format((float)($total2),2,'.','');
    $tps = CompareType($row['type']);

    if(strcmp($row['type'],"SinglePhase")==0)
    {
      $ca = ($c*1000) / ($ph);
      $da = ($d*1000) / ($ph);
      $ca = number_format((float)($ca),2,'.','');
      $da = number_format((float)($da),2,'.','');
    }
    else
    {
      $ca = ($c*1000) / (sqrt(3)*$ph);
      $da = ($d*1000) / (sqrt(3)*$ph);
      $ca = number_format((float)($ca),2,'.','');
      $da = number_format((float)($da),2,'.','');
    }
    $txt =
    "{
      'type':'$tps',
      'info':{
        'Job Number':'$_GET[jn]',
        'panel':'$pne',
        'location':'$row[location]',
        'service':'$row[service]',
        'neutral bus':'$row[neutralbus]',
        'main breaker':'$row[breaker]',
        'groundbus':'$row[groundbus]',
        'scr':'$row[rating]',
        'Main Lug':'$row[lug]',
        'Note':'$row[notes]',
        'mounting':'$row[mounting]'
      },
      'connected load':{
        'phase a':'$c1',
        'phase b':'$c2',
        'phase c':'$c3',
        'total'  :'$c',
        'AMPS':'$ca'
      },
      'demand load':{
        'phase a':'$d1',
        'phase b':'$d2',
        'phase c':'$d3',
        'total'  :'$d',
        'AMPS':'$da'
      },
      'keys':{";
        fwrite($myfile, $txt);
        $keys = array();
        $keyDerating = array();
        $sql2 = "SELECT * FROM test.keys WHERE jn ='$_GET[jn]'";

        $result1 = $conn->query($sql2);
        while($row = mysqli_fetch_array($result1))
        {
          $keys +=[strtoupper($row['keyname']) => $row['description']];
          $keyDerating +=[strtoupper($row['keyname']) => $row['derating']];
        }
        $counter = 0;
        $numResults = count($l[3]);

        foreach($l[3] as $key => $value) {
          $a = ($value * ($keyDerating[$key]/100)) /1000;
          $a = number_format((float)($a),2,'.','');
          //$a = number_format((float)(($a),2,'.',''));
          if (++$counter == $numResults) {
            $txt ="
            '$key':'$a',
            '$keys[$key]':'$keyDerating[$key] %'";
          }
          else
          {
            $txt ="
            '$key':'$a',
            '$keys[$key]':'$keyDerating[$key] %',";
          }
          fwrite($myfile, $txt);
        }
        $txt ="
      },
      'table':{";
        fwrite($myfile, $txt);

        $sql = "SELECT * FROM test.circuit
        WHERE jn = '$_GET[jn]' and panel = '".$pne."'";
        $result = $conn->query($sql);
        $counter = 0;
        $numResults = $result->num_rows;
        while($row = $result->fetch_assoc()){
          $As = $row['watts1'];
          $Bs = $row['watts2'];
          $Cs = $row['watts3'];
          $row['code'] = strtoupper($row['code']);
          if (++$counter == $numResults) {
            $txt = "
            '$row[circuit]':{
              'uses':'$row[code]: $row[uses]',".
              GeneraStr($tps,$row['circuit'],$As,$Bs,$Cs)
              ."'breaker' : '$row[bftype]'
            }
            ";
          }
          else{
            $txt = "
            '$row[circuit]':{
              'uses':'$row[code]: $row[uses]',".
              GeneraStr($tps,$row['circuit'],$As,$Bs,$Cs)
              ."'breaker' : '$row[bftype]'
            },
            ";
          }
          //echo $txt;
          fwrite($myfile, $txt);
        }
        $txt ="
      }
    }";
    fwrite($myfile, $txt);
    fclose($myfile);
    //echo "hello here $pne";
    //return 0;
  }
  return 0;
}


//Different type of panel passing different tpye of string to the autocard
function GeneraStr($type,$circuit,$Ae,$Be,$Ce)
{
  if($type ==1)
  {
    if(($circuit % 4) == 1 || ($circuit % 4) == 2)
    {
      return "
      'A' : '$Ae',
      ";
    }
    else
    {
      return "
      'B' : '$Be',
      ";
    }
  }
  else if($type == 2)
  {
    if(($circuit % 6) == 1||($circuit % 6) == 2)
    {
      return "
      'A' : '$Ae',
      ";
    }
    else if(($circuit % 6) == 3|| ($circuit % 6) == 4)
    {
      return "
      'B' : '$Be',
      ";
    }
    else
    {
      return "
      'C' : '$Ce',
      ";
    }
  }
  else if($type == 4)
  {
    return "
    'A' : '$Ae',
    ";
  }
  else {
    return "
    'A' : '$Ae',
    'B' : '$Be',
    'C' : '$Ce',
    ";
  }
}
//Get 3PH volt from service
function get3PHVOLTSe($Service)
{
  $contain;
  if(strpos($Service,'/')!==false)
  {
    $contain = true;
  }
  if($contain)
  {
    return get_string_between($Service,'/','V');
  }
  else
  {
    $arr = explode("V",$Service);
    return $arr[0];
  }
}

?>
