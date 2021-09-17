<?php 
require('../../../database_config/banchaclinic/config.inc.php');
require('../configuration/configuration.php');
require('../configuration/database.php'); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = new Database();
$conn = $db->conn();

$stage = '';
if(!isset($_GET['patient_id'])){ $db->close(); header('Location: ../404.php'); die(); }
$patient_id = mysqli_real_escape_string($conn, $_GET['patient_id']);

$strSQL = "SELECT * FROM bnc_service WHERE service_patient_id = '$patient_id' AND service_date = '$date' AND service_status IN ('admit', 'wait')";
$res = $db->fetch($strSQL, false);
if($res){
    $db->close();
    header('Location: ../html/core/system/app-healthrecord.php?patient_id='.$patient_id);
    die();
}else{

    $strSQL = "SELECT MAX(service_seq) MX FROM bnc_service WHERE 1";
    $res2 = $db->fetch($strSQL, false);
    $mx = 1;
    if(($res2) && ($res2['MX'] != null)){
        $mx = $res2['MX'] + 1;
    }
    $strSQL = "INSERT INTO bnc_service (`service_date`, `service_seq`, `service_status`, `service_cdatetime`, `service_patient_id`) 
               VALUES ('$date', '$mx', 'admit', '$datetime',  '$patient_id')
              ";
    $insert = $db->insert($strSQL, false);

    // echo $strSQL;
    // die();

    $db->close();
    header('Location: ../html/core/system/app-healthrecord.php?patient_id='.$patient_id);
    die();

}

