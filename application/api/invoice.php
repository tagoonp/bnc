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

if($stage == 'add'){
    if(
        (!isset($_REQUEST['uid'])) ||
        (!isset($_REQUEST['inv_no'])) ||
        (!isset($_REQUEST['inv_company'])) ||
        (!isset($_REQUEST['inv_date'])) ||
        (!isset($_REQUEST['inv_money']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $inv_no = mysqli_real_escape_string($conn, $_REQUEST['inv_no']);
    $inv_company = mysqli_real_escape_string($conn, $_REQUEST['inv_company']);
    $inv_date = mysqli_real_escape_string($conn, $_REQUEST['inv_date']);
    $inv_money = mysqli_real_escape_string($conn, $_REQUEST['inv_money']);


    $strSQL = "SELECT * FROM bnc_invoice WHERE inv_number = '$inv_no' AND inv_company = '$inv_company' AND inv_delete = 'N'";
    $res = $db->fetch($strSQL, true, true);
    if(($res) && ($res['count'] > 0)){
        $return['status'] = 'Duplicate';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $strSQL = "INSERT INTO bnc_invoice (`inv_date`, `inv_company`, `inv_number`, `inv_cost`, `inv_udatetime`, `inv_uid`) 
               VALUES ('$inv_date', '$inv_company', '$inv_no', '$inv_money', '$datetime', '$uid')
              ";
    $resInsert = $db->insert($strSQL, false);
    if($resInsert){
        $return['status'] = 'Success';
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
    }

    echo json_encode($return);
    $db->close(); 
    die(); 
}

if($stage == 'update'){
    if(
        (!isset($_REQUEST['uid'])) ||
        (!isset($_REQUEST['inv_no'])) ||
        (!isset($_REQUEST['inv_company'])) ||
        (!isset($_REQUEST['inv_duedate'])) ||
        (!isset($_REQUEST['inv_money'])) ||
        (!isset($_REQUEST['inv_disc'])) ||
        (!isset($_REQUEST['inv_chkno']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $inv_id = mysqli_real_escape_string($conn, $_REQUEST['inv_id']);
    $inv_no = mysqli_real_escape_string($conn, $_REQUEST['inv_no']);
    $inv_company = mysqli_real_escape_string($conn, $_REQUEST['inv_company']);
    $inv_duedate = mysqli_real_escape_string($conn, $_REQUEST['inv_duedate']);
    $inv_money = mysqli_real_escape_string($conn, $_REQUEST['inv_money']);
    $inv_disc = mysqli_real_escape_string($conn, $_REQUEST['inv_disc']);
    $inv_chkno = mysqli_real_escape_string($conn, $_REQUEST['inv_chkno']);

    $strSQL = "UPDATE bnc_invoice 
               SET 
               inv_company = '$inv_company',
               inv_number = '$inv_no',
               inv_cost = '$inv_money',
               inv_discount = '$inv_disc',
               inv_due_date = '$inv_duedate',
               inv_check = '$inv_chkno',
               inv_uid = '$uid',
               inv_udatetime = '$datetime'
               WHERE 
               inv_id = '$inv_id'
               ";
    $res = $db->execute($strSQL);
    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die(); 
}

if($stage == 'update2'){
    if(
        (!isset($_REQUEST['uid'])) ||
        (!isset($_REQUEST['inv_no'])) ||
        (!isset($_REQUEST['inv_company'])) ||
        (!isset($_REQUEST['inv_duedate'])) ||
        (!isset($_REQUEST['inv_money'])) ||
        (!isset($_REQUEST['inv_disc'])) ||
        (!isset($_REQUEST['inv_chkno']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $inv_id = mysqli_real_escape_string($conn, $_REQUEST['inv_id']);
    $inv_no = mysqli_real_escape_string($conn, $_REQUEST['inv_no']);
    $inv_company = mysqli_real_escape_string($conn, $_REQUEST['inv_company']);
    $inv_duedate = mysqli_real_escape_string($conn, $_REQUEST['inv_duedate']);
    $inv_money = mysqli_real_escape_string($conn, $_REQUEST['inv_money']);
    $inv_disc = mysqli_real_escape_string($conn, $_REQUEST['inv_disc']);
    $inv_chkno = mysqli_real_escape_string($conn, $_REQUEST['inv_chkno']);

    $strSQL = "UPDATE bnc_invoice 
               SET 
               inv_company = '$inv_company',
               inv_number = '$inv_no',
               inv_cost = '$inv_money',
               inv_discount = '$inv_disc',
               inv_due_date = '$inv_duedate',
               inv_check = '$inv_chkno',
               inv_uid = '$uid',
               inv_udatetime = '$datetime',
               inv_paystage = 'Y'
               WHERE 
               inv_id = '$inv_id'
               ";
    $res = $db->execute($strSQL);
    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die(); 
}

if($stage == 'info'){
    if(
        (!isset($_REQUEST['inv_id']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $inv_id = mysqli_real_escape_string($conn, $_REQUEST['inv_id']);

    $strSQL = "SELECT * FROM bnc_invoice WHERE inv_id = '$inv_id' AND inv_delete = 'N'";
    $res = $db->fetch($strSQL, false);
    if($res){
        $return['status'] = 'Success';
        $return['data'] = $res;
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
    }
    echo json_encode($return);
    $db->close(); 
    die();
}
if($stage == 'delete'){
    if(
        (!isset($_REQUEST['uid'])) ||
        (!isset($_REQUEST['inv_id']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $inv_id = mysqli_real_escape_string($conn, $_REQUEST['inv_id']);

    $strSQL = "UPDATE bnc_invoice SET inv_delete = 'Y', inv_udatetime = '$datetime', inv_uid = '$uid' WHERE inv_id = '$inv_id'";
    $res = $db->execute($strSQL);
    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die(); 
}