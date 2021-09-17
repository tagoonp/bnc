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
if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404.php'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);

if($stage == 'createsession'){

    if(!isset($_GET['uid'])){ $db->close(); header('Location: ../404.php'); die(); }
    $uid = mysqli_real_escape_string($conn, $_GET['uid']);

    $strSQL = "SELECT * FROM bcn_account WHERE ID = '$uid' AND active_status = '1'";
    $result = $db->fetch($strSQL, false);
    if($result){
        $_SESSION['bnc_id'] = session_id();
        $_SESSION['bnc_uid'] = $uid ;
        $db->close();
        header('Location: ../html/core/system/index.php');
        die();
    }else{
        $db->close();
        header('Location: ../login.php?stage=fail1');
        die();
    }
}

if($stage == 'closesession'){
    unset($_SESSION['bnc_id']);
    unset($_SESSION['bnc_uid']);
    session_destroy();
    $db->close();
    header('Location: ../html/core/login.php');
    die();
}


?>