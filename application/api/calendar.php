<?php 
require('../../../database_config/banchaclinic/config.inc.php');
require('../configuration/configuration.php');
require('../configuration/database.php'); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = new Database();
$conn = $db->conn();

header('Content-Type: application/json');

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);
$return = array();

if($stage == 'getcalendar'){

    $strSQL = "SELECT * FROM bnc_appointment a INNER JOIN bcn_patient b ON a.app_patient_id = b.patient_id WHERE a.app_delete = 'N' AND b.patient_delete = '0' AND a.app_date >= '$date'";
    $res = $db->fetch($strSQL, true, true);

    if(($res) && ($res['status'])){
        foreach ($res['data'] as $row) {
            $buf = array();
            $buf['allDay'] = true;
            $buf['start'] = $row['app_date'];
            
            if($row['app_place'] == 'clinic'){
                $buf['title'] = "CL : ". $row['patient_fname']. " " . $row['patient_lname'];
                $buf['color'] = '#02b869';
            }else{
                $buf['title'] = "HOSP : ". $row['patient_fname']. " " . $row['patient_lname'];
                $buf['color'] = '#b10000'; 
            }
            
            $buf['url'] = "Javascript:viewPatientInfo('".$row['app_patient_id']."')";
            $return[] = $buf;
        }
    }else{
        echo $strSQL;
    }

    echo json_encode($return, JSON_PRETTY_PRINT);
    $db->close(); 
    die();
}
?>