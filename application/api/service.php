<?php 
require('../../../database_config/banchaclinic/config.inc.php');
require('../configuration/configuration.php');
require('../configuration/database.php'); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = new Database();
$conn = $db->conn();

$return = array();

$stage = '';
if(!isset($_GET['stage'])){ 
    $return['status'] = 'Fail';
    $return['error_stage'] = '0';
    echo json_encode($return);
    $db->close(); 
    die(); 
}

$stage = mysqli_real_escape_string($conn, $_GET['stage']);


if($stage == 'deleteservice'){
    if(
        (!isset($_REQUEST['service_id'])) ||
        (!isset($_REQUEST['uid']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $service_id = mysqli_real_escape_string($conn, $_REQUEST['service_id']);
    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);

    $strSQL = "UPDATE bnc_service SET service_delete = '1' WHERE service_id = '$service_id'";
    $res = $db->execute($strSQL);

    $strSQL = "INSERT INTO bnc_log (`log_ip`, `log_datetime`, `log_activity`, `log_info`, `log_uid`) VALUES ('$ip', '$datetime', 'Delete un-complete service', 'Service ID $service_id', '$uid')";
    $res3 = $db->insert($strSQL, false);
    $return['status'] = 'Success';

    echo json_encode($return);
    $db->close(); 
    die(); 
}

if($stage == 'deleteapp'){
    if(
        (!isset($_REQUEST['app_id'])) ||
        (!isset($_REQUEST['uid']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $app_id = mysqli_real_escape_string($conn, $_REQUEST['app_id']);
    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);

    $strSQL = "UPDATE bnc_appointment SET app_delete = 'Y' WHERE app_id = '$app_id'";
    $res = $db->execute($strSQL);

    $strSQL = "INSERT INTO bnc_log (`log_ip`, `log_datetime`, `log_activity`, `log_info`, `log_uid`) VALUES ('$ip', '$datetime', 'Delete appointment', 'Appointment ID $app_id', '$uid')";
    $res3 = $db->insert($strSQL, false);
    $return['status'] = 'Success';

    echo json_encode($return);
    $db->close(); 
    die(); 
}