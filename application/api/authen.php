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

if($stage == 'checklogin'){
    if(
        (!isset($_REQUEST['username'])) ||
        (!isset($_REQUEST['password']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $username = mysqli_real_escape_string($conn, $_REQUEST['username']);
    $password = mysqli_real_escape_string($conn, $_REQUEST['password']);

    $strSQL = "SELECT * FROM bcn_account WHERE username = '$username' AND active_status = '1'";
    $result = $db->fetch($strSQL, false);

    if($result){
        if (password_verify($password, $result['password'])) {
            $return['status'] = 'Success';
            $return['uid'] = $result['ID'];
        } else {
            $return['status'] = 'Fail';
            $return['error_stage'] = '3';
        }
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
    }

    echo json_encode($return);
    $db->close(); 
    die(); 
}
?>