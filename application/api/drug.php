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

if($stage == 'info'){
    if(
        (!isset($_REQUEST['id'])) ||
        (!isset($_REQUEST['by']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $id = mysqli_real_escape_string($conn, $_REQUEST['id']);
    $by = mysqli_real_escape_string($conn, $_REQUEST['by']);

    if($by == 'id'){
        $strSQL = "SELECT * FROM bnc_drug_tmp WHERE ID = '$id'";
        $res = $db->fetch($strSQL, false);
        if($res){
            $return['status'] = 'Success';
            $return['data'] = $res;
        }else{
            $return['status'] = 'Fail';
            $return['error_stage'] = '2';
        }
    }else{
        $strSQL = "SELECT * FROM bnc_drug_tmp WHERE did = '$id'";
        $res = $db->fetch($strSQL, false);
        if($res){
            $return['status'] = 'Success';
            $return['data'] = $res;
        }else{
            $return['status'] = 'Fail';
            $return['error_stage'] = '2';
        }
    }
    
    
    echo json_encode($return);
    $db->close(); 
    die(); 
}

if($stage == 'delete'){
    if(
        (!isset($_REQUEST['rid']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $id = mysqli_real_escape_string($conn, $_REQUEST['rid']);

    $strSQL = "UPDATE bnc_drug_tmp SET ddelete = '1' WHERE ID = '$id'";
    $res = $db->execute($strSQL);

    $strSQL = "INSERT INTO bnc_log (`log_ip`, `log_datetime`, `log_activity`, `log_info`, `log_uid`)
                VALUES 
                (
                    '$ip', '$datetime', 'Delete drug', 'Drug Record ID $id', '".$_SESSION['bnc_uid']."'
                )
                ";
    $res3 = $db->insert($strSQL, false);
    $return['status'] = 'Success';

    echo json_encode($return);
    $db->close(); 
    die(); 
}

if($stage == 'getlist'){
    if(
        (!isset($_REQUEST['patient_id'])) ||
        (!isset($_REQUEST['seq']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $patient_id = mysqli_real_escape_string($conn, $_REQUEST['patient_id']);
    $seq = mysqli_real_escape_string($conn, $_REQUEST['seq']);

    $strSQL = "SELECT * FROM bnc_druglist WHERE dlist_seq = '$seq' AND dlist_patient_id = '$patient_id'";
    $res = $db->fetch($strSQL, true, false);
    if(($res) && ($res['status'])){
        $return['status'] = 'Success';
        $return['data'] = $res['data'];
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
        $return['error_command'] = $strSQL;
    }
    echo json_encode($return);
    $db->close(); 
    die(); 
}

if($stage == 'deletelist'){
    if(
        (!isset($_REQUEST['rid']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $rid = mysqli_real_escape_string($conn, $_REQUEST['rid']);

    $strSQL = "DELETE FROM bnc_druglist WHERE dlist_id = '$rid'";
    $res = $db->execute($strSQL);

    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die(); 
}

if($stage == 'addlist'){
    if(
        (!isset($_REQUEST['patient_id'])) ||
        (!isset($_REQUEST['drug_id'])) ||
        (!isset($_REQUEST['ref_drug_id'])) ||
        (!isset($_REQUEST['drug_name'])) ||
        (!isset($_REQUEST['drug_qty'])) ||
        (!isset($_REQUEST['drug_sum']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $patient_id = mysqli_real_escape_string($conn, $_REQUEST['patient_id']);
    $drug_id = mysqli_real_escape_string($conn, $_REQUEST['drug_id']);
    $ref_drug_id = mysqli_real_escape_string($conn, $_REQUEST['ref_drug_id']);
    $drug_name = mysqli_real_escape_string($conn, $_REQUEST['drug_name']);
    $drug_qty = mysqli_real_escape_string($conn, $_REQUEST['drug_qty']);
    $drug_sum = mysqli_real_escape_string($conn, $_REQUEST['drug_sum']);
    $drug_price = mysqli_real_escape_string($conn, $_REQUEST['drug_price']);
    $drug_cost = mysqli_real_escape_string($conn, $_REQUEST['drug_cost']);
    

    $strSQL = "SELECT * FROM bnc_service WHERE service_patient_id = '$patient_id' AND service_date = '$date' AND service_status IN ('admit', 'wait') ORDER BY service_cdatetime DESC LIMIT 1 ";
    $lasted_adm = $db->fetch($strSQL, false);

    if($lasted_adm){
        $seq = $lasted_adm['service_seq'];

        $strSQL = "SELECT * FROM bnc_druglist WHERE dlist_did = '$ref_drug_id' AND dlist_patient_id = '$patient_id' AND dlist_seq = '$seq'";
        $resCheck = $db->fetch($strSQL, false);
        if($resCheck){
            $strSQL = "DELETE FROM bnc_druglist WHERE dlist_did = '$ref_drug_id' AND dlist_patient_id = '$patient_id' AND dlist_seq = '$seq'";
            $db->execute($strSQL);
        }

        $drug_sumcost = $drug_qty * $drug_cost;

        $strSQL = "INSERT INTO bnc_druglist 
                   (`dlist_seq`, `dlist_did`, `dlist_drugname`, `dlist_qty`, `dlist_cost`, 
                   `dlist_price`, `dlist_sumcost`, `dlist_sumprice`, `dlist_datetime`, `dlist_patient_id`) 
                   VALUES (
                       '$seq', '$ref_drug_id', '$drug_name', '$drug_qty', '$drug_cost', 
                       '$drug_price', '$drug_sumcost', '$drug_sum', '$datetime', '$patient_id'
                   )
                   ";
        $res = $db->insert($strSQL, false);
        if($res){
            $return['status'] = 'Success';
        }else{
            $return['status'] = 'Fail';
            $return['error_stage'] = '2';
        }
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '3';
        $return['error_command'] = $strSQL;
    }
    
    echo json_encode($return);
    $db->close(); 
    die(); 
}

if($stage == 'addlist2'){
    if(
        (!isset($_REQUEST['patient_id'])) ||
        (!isset($_REQUEST['drug_id'])) ||
        (!isset($_REQUEST['ref_drug_id'])) ||
        (!isset($_REQUEST['drug_name'])) ||
        (!isset($_REQUEST['drug_qty'])) ||
        (!isset($_REQUEST['drug_sum'])) ||
        (!isset($_REQUEST['service_seq']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $patient_id = mysqli_real_escape_string($conn, $_REQUEST['patient_id']);
    $drug_id = mysqli_real_escape_string($conn, $_REQUEST['drug_id']);
    $ref_drug_id = mysqli_real_escape_string($conn, $_REQUEST['ref_drug_id']);
    $drug_name = mysqli_real_escape_string($conn, $_REQUEST['drug_name']);
    $drug_qty = mysqli_real_escape_string($conn, $_REQUEST['drug_qty']);
    $drug_sum = mysqli_real_escape_string($conn, $_REQUEST['drug_sum']);
    $drug_price = mysqli_real_escape_string($conn, $_REQUEST['drug_price']);
    $drug_cost = mysqli_real_escape_string($conn, $_REQUEST['drug_cost']);
    $service_seq = mysqli_real_escape_string($conn, $_REQUEST['service_seq']);
    

    $seq = $service_seq;

    $strSQL = "SELECT * FROM bnc_druglist WHERE dlist_did = '$ref_drug_id' AND dlist_patient_id = '$patient_id' AND dlist_seq = '$seq'";
    $resCheck = $db->fetch($strSQL, false);
    if($resCheck){
        $strSQL = "DELETE FROM bnc_druglist WHERE dlist_did = '$ref_drug_id' AND dlist_patient_id = '$patient_id' AND dlist_seq = '$seq'";
        $db->execute($strSQL);
    }

    $drug_sumcost = $drug_qty * $drug_cost;

    $strSQL = "INSERT INTO bnc_druglist 
                (`dlist_seq`, `dlist_did`, `dlist_drugname`, `dlist_qty`, `dlist_cost`, 
                `dlist_price`, `dlist_sumcost`, `dlist_sumprice`, `dlist_datetime`, `dlist_patient_id`) 
                VALUES (
                    '$seq', '$ref_drug_id', '$drug_name', '$drug_qty', '$drug_cost', 
                    '$drug_price', '$drug_sumcost', '$drug_sum', '$datetime', '$patient_id'
                )
                ";
    $res = $db->insert($strSQL, false);
    if($res){
        $return['status'] = 'Success';
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
    }
    
    echo json_encode($return);
    $db->close(); 
    die(); 
}

if($stage == 'saveOther'){

    $patient_id = mysqli_real_escape_string($conn, $_REQUEST['patient_id']);
    $otherItem = mysqli_real_escape_string($conn, $_REQUEST['otherItem']);
    $otherCost = mysqli_real_escape_string($conn, $_REQUEST['otherCost']);
    

    $strSQL = "SELECT * FROM bnc_service WHERE service_patient_id = '$patient_id' AND service_date = '$date' AND service_status = 'admit' ORDER BY service_cdatetime DESC LIMIT 1 ";
    $lasted_adm = $db->fetch($strSQL, false);

    if($lasted_adm){
        $seq = $lasted_adm['service_seq'];

        // $strSQL = "SELECT * FROM bnc_druglist WHERE dlist_did = '$ref_drug_id' AND dlist_patient_id = '$patient_id' AND dlist_seq = '$seq'";
        // $resCheck = $db->fetch($strSQL, false);
        // if($resCheck){
        //     $strSQL = "DELETE FROM bnc_druglist WHERE dlist_did = '$ref_drug_id' AND dlist_patient_id = '$patient_id' AND dlist_seq = '$seq'";
        //     $db->execute($strSQL);
        // }

        // $drug_sumcost = $drug_qty * $drug_cost;

        $strSQL = "INSERT INTO bnc_druglist 
                   (`dlist_seq`, `dlist_did`, `dlist_drugname`, `dlist_qty`, `dlist_cost`, 
                   `dlist_price`, `dlist_sumcost`, `dlist_sumprice`, `dlist_datetime`, `dlist_patient_id`) 
                   VALUES (
                       '$seq', '99999', '$otherItem', '1', '$otherCost', 
                       '$otherCost', '$otherCost', '$otherCost', '$datetime', '$patient_id'
                   )
                   ";
        $res = $db->insert($strSQL, false);
        if($res){
            $return['status'] = 'Success';
        }else{
            $return['status'] = 'Fail';
            $return['error_stage'] = '2';
        }
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '3';
        $return['error_command'] = $strSQL;
    }
    
    echo json_encode($return);
    $db->close(); 
    die(); 
}

if($stage == 'finishservice'){
    if(
        (!isset($_REQUEST['seq'])) ||
        (!isset($_REQUEST['patient_id'])) ||
        (!isset($_REQUEST['fcost'])) ||
        (!isset($_REQUEST['fprice'])) ||
        (!isset($_REQUEST['ftotal'])) ||
        (!isset($_REQUEST['df'])) ||
        (!isset($_REQUEST['ptype'])) ||
        (!isset($_REQUEST['rprice']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $seq = mysqli_real_escape_string($conn, $_REQUEST['seq']);
    $patient_id = mysqli_real_escape_string($conn, $_REQUEST['patient_id']);
    $fcost = mysqli_real_escape_string($conn, $_REQUEST['fcost']);
    $fprice = mysqli_real_escape_string($conn, $_REQUEST['fprice']);
    $ftotal = mysqli_real_escape_string($conn, $_REQUEST['ftotal']);
    $df = mysqli_real_escape_string($conn, $_REQUEST['df']);
    $ptype = mysqli_real_escape_string($conn, $_REQUEST['ptype']);
    $dnote = mysqli_real_escape_string($conn, $_REQUEST['dnote']);
    $stype = mysqli_real_escape_string($conn, $_REQUEST['stype']);
    $rprice = mysqli_real_escape_string($conn, $_REQUEST['rprice']);
    

    $strSQL = "SELECT * FROM bnc_service WHERE service_seq = '$seq' AND service_patient_id = '$patient_id' LIMIT 1";
    $res = $db->fetch($strSQL,false);
    if($res){
        $strSQL = "UPDATE bnc_service 
                   SET 
                   service_edatetime = '$datetime', 
                   service_cost = '$fcost', 
                   service_price = '$fprice', 
                   service_df = '$df', 
                   service_paytype = '$ptype', 
                   service_doctornote = '$dnote',
                   service_total = '$ftotal',
                   service_finalprice = '$rprice',
                   service_status = 'discharge',
                   service_type = '$stype'
                   WHERE 
                   service_seq = '$seq' AND service_patient_id = '$patient_id'
                  ";
        $res = $db->execute($strSQL);
        $return['status'] = 'Success';

        $strSQL = "SELECT * FROM bnc_druglist WHERE dlist_seq = '$seq' AND dlist_patient_id = '$patient_id'";
        $resDlist = $db->fetch($strSQL, true, false);
        if(($resDlist) && ($resDlist['status'])){
            foreach($resDlist['data'] as $row){
                $dq = $row['dlist_qty'];
                $strSQL = "SELECT ID, dstock FROM bnc_drug_tmp WHERE did = '".$row['dlist_did']."' LIMIT 1";
                $resD = $db->fetch($strSQL, false);
                if($resD){
                    $dold = $resD['dstock'];
                    $newq = $resD['dstock'] - $dq;

                    if($newq < 0){
                        $newq = 0;
                    }
                    $id = $resD['ID']; 

                    $strSQL = "UPDATE bnc_drug_tmp SET dstock = '$newq' WHERE ID = '$id'";
                    $res = $db->execute($strSQL);

                    $strSQL = "INSERT INTO bnc_stock_stagement (`ss_drug_id`, `ss_stage`, `ss_qty`, `ss_datetime`) VALUES ('$id', 'service', '$newq', '$datetime')";
                    $res = $db->execute($strSQL);

                }
            }
        }
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
    }
    echo json_encode($return);
    $db->close(); 
    die(); 
}

if($stage == 'finishservicewait'){
    if(
        (!isset($_REQUEST['seq'])) ||
        (!isset($_REQUEST['patient_id'])) ||
        (!isset($_REQUEST['fcost'])) ||
        (!isset($_REQUEST['fprice'])) ||
        (!isset($_REQUEST['ftotal'])) ||
        (!isset($_REQUEST['df'])) ||
        (!isset($_REQUEST['ptype'])) ||
        (!isset($_REQUEST['stype'])) ||
        (!isset($_REQUEST['rprice']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $seq = mysqli_real_escape_string($conn, $_REQUEST['seq']);
    $patient_id = mysqli_real_escape_string($conn, $_REQUEST['patient_id']);
    $fcost = mysqli_real_escape_string($conn, $_REQUEST['fcost']);
    $fprice = mysqli_real_escape_string($conn, $_REQUEST['fprice']);
    $ftotal = mysqli_real_escape_string($conn, $_REQUEST['ftotal']);
    $df = mysqli_real_escape_string($conn, $_REQUEST['df']);
    $ptype = mysqli_real_escape_string($conn, $_REQUEST['ptype']);
    $stype = mysqli_real_escape_string($conn, $_REQUEST['stype']);
    $rprice = mysqli_real_escape_string($conn, $_REQUEST['rprice']);
    $dnote = mysqli_real_escape_string($conn, $_REQUEST['dnote']);

    $strSQL = "SELECT * FROM bnc_service WHERE service_seq = '$seq' AND service_patient_id = '$patient_id' LIMIT 1";
    $res = $db->fetch($strSQL,false);
    if($res){
        $strSQL = "UPDATE bnc_service 
                   SET 
                   service_edatetime = '$datetime', 
                   service_cost = '$fcost', 
                   service_price = '$fprice', 
                   service_df = '$df', 
                   service_paytype = '$ptype', 
                   service_doctornote = '$dnote',
                   service_total = '$ftotal',
                   service_finalprice = '$rprice',
                   service_status = 'wait',
                   service_type = '$stype'
                   WHERE 
                   service_seq = '$seq' AND service_patient_id = '$patient_id'
                  ";
        $res = $db->execute($strSQL);
        $return['status'] = 'Success';

        $strSQL = "SELECT * FROM bnc_druglist WHERE dlist_seq = '$seq' AND dlist_patient_id = '$patient_id'";
        $resDlist = $db->fetch($strSQL, true, false);
        if(($resDlist) && ($resDlist['status'])){
            foreach($resDlist['data'] as $row){
                $dq = $row['dlist_qty'];
                $strSQL = "SELECT ID, dstock FROM bnc_drug_tmp WHERE did = '".$row['dlist_did']."' LIMIT 1";
                $resD = $db->fetch($strSQL, false);
                if($resD){
                    $dold = $resD['dstock'];
                    $newq = $resD['dstock'] - $dq;

                    if($newq < 0){
                        $newq = 0;
                    }
                    $id = $resD['ID']; 

                    $strSQL = "UPDATE bnc_drug_tmp SET dstock = '$newq' WHERE ID = '$id'";
                    $res = $db->execute($strSQL);

                    $strSQL = "INSERT INTO bnc_stock_stagement (`ss_drug_id`, `ss_stage`, `ss_qty`, `ss_datetime`) VALUES ('$id', 'service', '$newq', '$datetime')";
                    $res = $db->execute($strSQL);

                }
            }
        }
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
    }
    echo json_encode($return);
    $db->close(); 
    die(); 
}

if($stage == 'newstock'){
    if(
        (!isset($_REQUEST['did'])) ||
        (!isset($_REQUEST['newq']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $did = mysqli_real_escape_string($conn, $_REQUEST['did']);
    $newq = mysqli_real_escape_string($conn, $_REQUEST['newq']);

    $strSQL = "UPDATE bnc_drug_tmp SET dstock = '$newq' WHERE ID = '$did'";
    $res = $db->execute($strSQL);

    $strSQL = "INSERT INTO bnc_stock_stagement (`ss_drug_id`, `ss_stage`, `ss_qty`, `ss_datetime`) VALUES ('$did', 'addnew', '$newq', '$datetime')";
    $res = $db->insert($strSQL, false);

    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die(); 
}

if($stage == 'updatestock'){
    if(
        (!isset($_REQUEST['did'])) ||
        (!isset($_REQUEST['newq']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $did = mysqli_real_escape_string($conn, $_REQUEST['did']);
    $newq = mysqli_real_escape_string($conn, $_REQUEST['newq']);

    $strSQL = "UPDATE bnc_drug_tmp SET dstock = '$newq' WHERE ID = '$did'";
    $res = $db->execute($strSQL);

    $strSQL = "INSERT INTO bnc_stock_stagement (`ss_drug_id`, `ss_stage`, `ss_qty`, `ss_datetime`) VALUES ('$did', 'update', '$newq', '$datetime')";
    $res = $db->insert($strSQL, false);

    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die(); 
}

if($stage == 'new'){
    if(
        (!isset($_REQUEST['did'])) ||
        (!isset($_REQUEST['tname'])) ||
        (!isset($_REQUEST['gname'])) ||
        (!isset($_REQUEST['dose'])) ||
        (!isset($_REQUEST['cost'])) ||
        (!isset($_REQUEST['price']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $did = mysqli_real_escape_string($conn, $_REQUEST['did']);
    $tname = mysqli_real_escape_string($conn, $_REQUEST['tname']);
    $gname = mysqli_real_escape_string($conn, $_REQUEST['gname']);
    $dose = mysqli_real_escape_string($conn, $_REQUEST['dose']);
    $cost = mysqli_real_escape_string($conn, $_REQUEST['cost']);
    $price = mysqli_real_escape_string($conn, $_REQUEST['price']);

    $strSQL = "SELECT * FROM bnc_drug_tmp WHERE did = '$did' AND ddelete = '0'";
    $res = $db->fetch($strSQL, false);
    if($res){
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
        echo json_encode($return);
        $db->close(); 
        die();
    }
    
    $strSQL = "INSERT INTO bnc_drug_tmp (`dname`, `dcname`, `ddose`, `did`, `dcost`, `dprice`, `dverify`, `dudatetime`) 
               VALUES (
                   '$tname', '$gname', '$dose', '$did', '$cost', 
                   '$price', '1', '$datetime'
               )";
    $result = $db->insert($strSQL, false);
    if($result){
        $strSQL = "INSERT INTO bnc_log (`log_ip`, `log_datetime`, `log_activity`, `log_info`, `log_uid`)
                   VALUES 
                   (
                       '$ip', '$datetime', 'Add new drug', 'Drug Name $tname', '".$_SESSION['bnc_uid']."'
                   )
                  ";
        $res3 = $db->insert($strSQL, false);
        $return['status'] = 'Success';
    }
    else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '3';
    }


    echo json_encode($return);
    $db->close(); 
    die(); 
}

if($stage == 'update'){
    if(
        (!isset($_REQUEST['rid'])) ||
        (!isset($_REQUEST['did'])) ||
        (!isset($_REQUEST['tname'])) ||
        (!isset($_REQUEST['gname'])) ||
        (!isset($_REQUEST['dose'])) ||
        (!isset($_REQUEST['cost'])) ||
        (!isset($_REQUEST['price']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die(); 
    }

    $id = mysqli_real_escape_string($conn, $_REQUEST['rid']);
    $did = mysqli_real_escape_string($conn, $_REQUEST['did']);
    $tname = mysqli_real_escape_string($conn, $_REQUEST['tname']);
    $gname = mysqli_real_escape_string($conn, $_REQUEST['gname']);
    $dose = mysqli_real_escape_string($conn, $_REQUEST['dose']);
    $cost = mysqli_real_escape_string($conn, $_REQUEST['cost']);
    $price = mysqli_real_escape_string($conn, $_REQUEST['price']);

    $strSQL = "SELECT * FROM bnc_drug_tmp WHERE ID = '$id'";
    $res = $db->fetch($strSQL, false);
    if($res){
        
        $strSQL = "UPDATE bnc_drug_tmp
                   SET 
                   dname = '$tname',
                   dcname = '$gname',
                   ddose = '$dose',
                   did = '$did',
                   dcost = '$cost',
                   dprice = '$price',
                   dverify = '1',
                   dudatetime = '$datetime'
                   WHERE 
                   ID = '$id'
                  ";
        $res2 = $db->execute($strSQL);

        $strSQL = "INSERT INTO bnc_log (`log_ip`, `log_datetime`, `log_activity`, `log_info`, `log_uid`)
                   VALUES 
                   (
                       '$ip', '$datetime', 'Update drug', 'Drug ID $did (Record id : $id)', '".$_SESSION['bnc_uid']."'
                   )
                  ";
        $res3 = $db->insert($strSQL, false);

        $return['status'] = 'Success';

    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
    }


    echo json_encode($return);
    $db->close(); 
    die(); 
}
?>