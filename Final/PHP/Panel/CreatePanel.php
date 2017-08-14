<?php
if(isset($_POST['apn']))
{
  //include('../Functions/Methods.php');
  $panel = $_POST['panel']; $type = $_POST['type'];
  $location = $_POST['location'];
  $circuit = $_POST['circuit'];
  if(empty($panel))
  {
    $panel = "MDP";
  }
  if(empty($circuit))
  {
    $circuit = 42;
  }
  $service = $_POST['service']; $mounting = $_POST['mounting'];
  $rating = $_POST['rating'];
  $lug = $_POST['lug'];
  if(empty($rating))
  {
    $rating = 10;
  }
  $aicrating = $_POST['aicrating'];
  if(empty($aicrating))
  {
    $aicrating = 10;
  }
  $phases = $_POST['phases']; $breaker = $_POST['breaker'];
  $groundbus = $_POST['groundbus']; $neutralbus = $_POST['neutralbus'];
  //echo "type: $groundbus <br>";
  $firstphase = $_POST['firstphase']; $notes = $_POST['notes'];
  //Select types to insert into Panel Database
  $t = array('ThreePhase','SinglePhase','Isolation');

  $breaks = '20A-3P';
  if(in_array($type,$t))
  {
    $breaks = '20A-1P';
  }
  $sql = "INSERT INTO test.panel(panel,type,location,circuit,
    service,mounting,rating,aicrating,phases,breaker,groundbus,
    neutralbus,firstphase,notes,jn,lug)
    VALUES ('$panel','$type','$location','$circuit','$service',
      '$mounting','$rating','$aicrating','$phases','$breaker',
      '$groundbus','$neutralbus','$firstphase','$notes',$_GET[jn],'$lug')";
      if ($conn->query($sql) === TRUE) {
        echo "<br>has been added to Database";
        $cir =1;
        while($cir <= $circuit)
        {
          $sql = "INSERT INTO test.circuit(panel,circuit,code,linkphase,uses,bftype,jn)
          VALUES('$panel',$cir,'S',0,'  ','$breaks',$_GET[jn])";
          if ($conn->query($sql) === TRUE) {
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
          $cir++;
        }
      }
      else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
  }


  if(isset($_POST['isop']))
  {
    //include('../Functions/Methods.php');
    $panel = $_POST['panel']; $type = $_POST['type'];
    $location = $_POST['location'];
    $circuit = $_POST['circuit'];
    $lug = $_POST['lug'];
    if(empty($panel))
    {
      $panel = "MDP";
    }
    if(empty($circuit))
    {
      $circuit = 42;
    }
    $service = $_POST['service']; $mounting = $_POST['mounting'];
    $rating = $_POST['rating'];
    if(empty($rating))
    {
      $rating = 10;
    }
    $aicrating = $_POST['aicrating'];
    if(empty($aicrating))
    {
      $aicrating = 10;
    }
    $phases = $_POST['phases']; $breaker = $_POST['breaker'];
    $groundbus = $_POST['groundbus']; $neutralbus = $_POST['neutralbus'];
    //echo "type: $groundbus <br>";
    $firstphase = $_POST['firstphase']; $notes = $_POST['notes'];
    //Select types to insert into Panel Database
    $t = array('ThreePhase','SinglePhase');

    $breaks = '20A-3P';
    if(in_array($type,$t))
    {
      $breaks = '20A-1P';
    }
    $sql = "INSERT INTO test.panel(panel,type,location,circuit,
      service,mounting,rating,aicrating,phases,breaker,groundbus,
      neutralbus,firstphase,notes,jn,lug)
      VALUES ('$panel','$type','$location','$circuit','$service',
        '$mounting','$rating','$aicrating','$phases','$breaker',
        '$groundbus','$neutralbus','$firstphase','$notes',$_GET[jn],'$lug')";
        if ($conn->query($sql) === TRUE) {
          echo "<br>has been added to Database";
          $cir =1;
          while($cir <= $circuit)
          {
            $sql = "INSERT INTO test.circuit(panel,circuit,code,linkphase,uses,bftype,jn)
            VALUES('$panel',$cir,'S',0,'  ','$breaks',$_GET[jn])";
            if ($conn->query($sql) === TRUE) {
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $cir++;
          }
        }
        else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
?>
