<?php 
if($_SESSION['bnc_id'] != session_id()){
    header('Location: '. ROOT_DOMAIN .'application/html/core/login.php');
    die();
}

if(!isset($_SESSION['bnc_uid'])){
    $db->close();
    header('Location: '. ROOT_DOMAIN .'application/html/core/login.php');
    die();
}

$uid = $_SESSION['bnc_uid'];

// $strSQL = "SELECT * FROM bcn_account WHERE ID = '$uid' AND role = '$role' AND active_status = '1'";
$strSQL = "SELECT * FROM bcn_account WHERE ID = '$uid' AND active_status = '1'";
$result = $db->fetch($strSQL, false);
if($result){
    $user = $result;
}else{
    $db->close();
    header('Location: ../login.php');
    die();
}
?>
<input type="hidden" id="txtUid" value="<?php echo $uid; ?>">