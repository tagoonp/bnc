<?php 
if(!isset($_SESSION['bnc_id'])){
    header('Location: ../login.php');
}

if($_SESSION['bnc_id'] != session_id()){
    header('Location: ../login.php');
}
?>