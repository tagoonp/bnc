<?php 

require('../../../../../database_config/banchaclinic/config.inc.php');
require('../../../configuration/configuration.php');
require('../../../configuration/database.php'); 

$db = new Database();
$conn = $db->conn();

require('../../../configuration/user.inc.php'); 

$page_id = 1;

$patient_id = '';
if(isset($_GET['patient_id'])){
    $patient_id = mysqli_real_escape_string($conn, $_REQUEST['patient_id']);
}else{

}

$service_id = '';
$service_found = false;
$service_data = false;
if(isset($_GET['service_id'])){
    $service_id = mysqli_real_escape_string($conn, $_REQUEST['service_id']);
    $strSQL = "SELECT * FROM bnc_service WHERE service_id = '$service_id'";
    $resService = $db->fetch($strSQL, false);
    if($resService){
        $service_found = true;
        $service_data = $resService;
    }
}

$searchResponse = null;
$searchResponse_count = 0;
if($patient_id != ''){
    $strSQL = "SELECT * FROM bcn_patient a LEFT JOIN bnc_patient_log b ON a.patient_id = b.pl_patient_id
           WHERE 
           a.patient_id = '$patient_id'
           AND a.patient_delete = '0'
           AND a.patient_record_status = '1'
           AND b.pl_patient_lasted = '1'
          ";
    $res = $db->fetch($strSQL, true, true);
    if(($res) && ($res['status'])){
        $searchResponse = $res['data'];
        if($res['count'] != 0){
            $searchResponse_count = $res['count'];
        }
    }
}

$strSQL = "SELECT * FROM bnc_service WHERE service_status IN ('admit', 'wait') AND service_patient_id = '$patient_id' AND service_delete = '0' ORDER BY service_cdatetime DESC LIMIT 1 ";
$lasted_adm = $db->fetch($strSQL, false);

if(!$lasted_adm){

}

?>

<input type="hidden" value="<?php echo $service_id;?>" id="txtServiceId">
<input type="hidden" value="<?php echo $patient_id;?>" id="txtPatientId">

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['app_title']; ?></title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/dragula.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/pickers/pickadate/pickadate.css">
    <link rel="stylesheet" type="text/css" href="../../../node_modules/preload.js/dist/css/preload.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/semi-dark-layout.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/editors/quill/katex.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/editors/quill/monokai-sublime.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/editors/quill/quill.snow.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/editors/quill/quill.bubble.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/widgets.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/dashboard-analytics.css">
    
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/form-quill-editor.css">
    <!-- END: Page CSS-->
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css?v=<?php echo filemtime('../../../assets/css/style.css'); ?>">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<style>
    
</style>

<!-- BEGIN: Body-->



<body class="horizontal-layout horizontal-menu navbar-static 2-columns   footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-static-top bg-success navbar-brand-center">
        <div class="navbar-header d-xl-block d-none">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item"><a class="navbar-brand" href="../../../html/ltr/horizontal-menu-template/index.php">
                        <div class="brand-logo"><img class="logo" src="../../../app-assets/images/logo/logo-light.png"></div>
                        <h2 class="brand-text mb-0">Bancha Clinic</h2>
                    </a></li>
            </ul>
        </div>
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu mr-auto"><a class="nav-link nav-menu-main menu-toggle" href="javascript:void(0);"><i class="bx bx-menu"></i></a></li>
                        </ul>
                        <ul class="nav navbar-nav bookmark-icons">
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-calendar.php" data-toggle="tooltip" data-placement="top" title="Calendar"><i class="ficon bx bx-calendar-alt"></i></a></li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right d-flex align-items-center">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon bx bx-fullscreen"></i></a></li>
                        <li class="nav-item nav-search"><a class="nav-link nav-link-search pt-2"><i class="ficon bx bx-search"></i></a>
                            <div class="search-input">
                                <div class="search-input-icon"><i class="bx bx-search primary"></i></div>
                                <input class="input" type="text" placeholder="ค้นหาผู้ป่วยด้วยรหัส ชื่อ หรือนามสกุล ..." tabindex="-1" data-search="template-search">
                                <div class="search-input-close"><i class="bx bx-x"></i></div>
                                <ul class="search-list"></ul>
                            </div>
                        </li>
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="javascript:void(0);" data-toggle="dropdown">
                                <div class="user-nav d-lg-flex d-none"><span class="user-status">Welcome,</span><span class="user-name"><?php echo $user['fullname']; ?></span></div><span><img class="round" src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="40" width="40"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right pb-0"><a class="dropdown-item" href="page-user-profile.php"><i class="bx bx-user mr-50"></i> Edit Profile</a>
                                <div class="dropdown-divider mb-0"></div><a class="dropdown-item" href="../../../controller/authen.php?stage=closesession"><i class="bx bx-power-off mr-50"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-sticky navbar-light navbar-without-dd-arrow" role="navigation" data-menu="menu-wrapper">
        <div class="navbar-header d-xl-none d-block">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="index.php">
                        <div class="brand-logo">
                            <svg class="logo" width="26px" height="26px" viewbox="0 0 26 26" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>icon</title>
                                <defs>
                                    <lineargradient id="linearGradient-1" x1="50%" y1="0%" x2="50%" y2="100%">
                                        <stop stop-color="#5A8DEE" offset="0%"></stop>
                                        <stop stop-color="#699AF9" offset="100%"></stop>
                                    </lineargradient>
                                    <lineargradient id="linearGradient-2" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop stop-color="#FDAC41" offset="0%"></stop>
                                        <stop stop-color="#E38100" offset="100%"></stop>
                                    </lineargradient>
                                </defs>
                                <g id="Sprite" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="sprite" transform="translate(-69.000000, -61.000000)">
                                        <g id="Group" transform="translate(17.000000, 15.000000)">
                                            <g id="icon" transform="translate(52.000000, 46.000000)">
                                                <path id="Combined-Shape" d="M13.5909091,1.77272727 C20.4442608,1.77272727 26,7.19618701 26,13.8863636 C26,20.5765403 20.4442608,26 13.5909091,26 C6.73755742,26 1.18181818,20.5765403 1.18181818,13.8863636 C1.18181818,13.540626 1.19665566,13.1982714 1.22574292,12.8598734 L6.30410592,12.859962 C6.25499466,13.1951893 6.22958398,13.5378796 6.22958398,13.8863636 C6.22958398,17.8551125 9.52536149,21.0724191 13.5909091,21.0724191 C17.6564567,21.0724191 20.9522342,17.8551125 20.9522342,13.8863636 C20.9522342,9.91761479 17.6564567,6.70030817 13.5909091,6.70030817 C13.2336969,6.70030817 12.8824272,6.72514561 12.5388136,6.77314791 L12.5392575,1.81561642 C12.8859498,1.78721495 13.2366963,1.77272727 13.5909091,1.77272727 Z"></path>
                                                <path id="Combined-Shape" d="M13.8863636,4.72727273 C18.9447899,4.72727273 23.0454545,8.82793741 23.0454545,13.8863636 C23.0454545,18.9447899 18.9447899,23.0454545 13.8863636,23.0454545 C8.82793741,23.0454545 4.72727273,18.9447899 4.72727273,13.8863636 C4.72727273,13.5378966 4.74673291,13.1939746 4.7846258,12.8556254 L8.55057141,12.8560055 C8.48653249,13.1896162 8.45300462,13.5340745 8.45300462,13.8863636 C8.45300462,16.887125 10.8856023,19.3197227 13.8863636,19.3197227 C16.887125,19.3197227 19.3197227,16.887125 19.3197227,13.8863636 C19.3197227,10.8856023 16.887125,8.45300462 13.8863636,8.45300462 C13.529522,8.45300462 13.180715,8.48740462 12.8430777,8.55306931 L12.8426531,4.78608796 C13.1851829,4.7472336 13.5334422,4.72727273 13.8863636,4.72727273 Z" fill="#4880EA"></path>
                                                <path id="Combined-Shape" d="M13.5909091,1.77272727 C20.4442608,1.77272727 26,7.19618701 26,13.8863636 C26,20.5765403 20.4442608,26 13.5909091,26 C6.73755742,26 1.18181818,20.5765403 1.18181818,13.8863636 C1.18181818,13.540626 1.19665566,13.1982714 1.22574292,12.8598734 L6.30410592,12.859962 C6.25499466,13.1951893 6.22958398,13.5378796 6.22958398,13.8863636 C6.22958398,17.8551125 9.52536149,21.0724191 13.5909091,21.0724191 C17.6564567,21.0724191 20.9522342,17.8551125 20.9522342,13.8863636 C20.9522342,9.91761479 17.6564567,6.70030817 13.5909091,6.70030817 C13.2336969,6.70030817 12.8824272,6.72514561 12.5388136,6.77314791 L12.5392575,1.81561642 C12.8859498,1.78721495 13.2366963,1.77272727 13.5909091,1.77272727 Z" fill="url(#linearGradient-1)"></path>
                                                <rect id="Rectangle" x="0" y="0" width="7.68181818" height="7.68181818"></rect>
                                                <rect id="Rectangle" fill="url(#linearGradient-2)" x="0" y="0" width="7.68181818" height="7.68181818"></rect>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <h2 class="brand-text mb-0">Bancha Clinic</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <!-- Horizontal menu content-->
        <?php 
        require('./componants/topmenu.php');
        ?>
        <!-- /horizontal menu content-->
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="breadcrumbs-top">
                        <h5 class="content-header-title float-left pr-1 mb-0 text-dark" style="font-size: 28px;">เวชระเบียนผู้ป่วย</h5>
                        <div class="breadcrumb-wrapper d-none d-sm-block" style="padding-top: 10px;">
                            <ol class="breadcrumb p-0 mb-0 pl-1">
                                <li class="breadcrumb-item"><a href="./"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="app-cashing.php">ระบบคิดเงิน</a></li>
                                <li class="breadcrumb-item active">บันทึกการรักษา/บริการ</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!--Success theme Modal -->
            <div class="modal fade text-left" id="modalMedPHR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h5 class="modal-title white" id="myModalLabel110"><i class="bx bxs-user-plus"></i> เพิ่มยา</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"  onclick="resetDrugform();">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <form id="newdruflistForm2" onsubmit="return false;">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-4 dn">
                                        <input type="text" id="txtSeq" name="txtSeq" value="<?php if($service_found){ echo $service_data['service_seq']; } ?>">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">Patient ID : <span class="text-danger">*</span>  </label>
                                            <input type="text" class="form-control" id="txtPid" name="txtPid" readonly value="<?php echo $patient_id; ?>">
                                        </div>
                                    </div>
                                    <div class="col-4 dn">
                                        <div class="form-group dn">
                                            <label for="" style="font-size: 18px !important;">ID : <span class="text-danger">*</span>  </label>
                                            <input type="text" class="form-control" id="txtDid" name="txtDid" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">ID : <span class="text-danger">*</span>  </label>
                                            <input type="text" class="form-control" id="txtDrugId" name="txtDrugId" readonly>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">ชื่อยา : <span class="text-danger">*</span>  </label>
                                            <input type="text" class="form-control" id="txtDrugTrade" readonly name="txtDrugTrade">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6 dn">
                                        <label for="" style="font-size: 18px !important;">ราคาทุน : <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="txtDrugCost" readonly name="txtDrugCost" step="0.5" min="0" >
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="" style="font-size: 18px !important;">ราคาขาย : <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="txtDrugPrice" readonly name="txtDrugPrice" step="0.5" min="0" >
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="" style="font-size: 18px !important;">จำนวนหน่วย : <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="txtDrugUnit" name="txtDrugUnit" step="0.5" min="0" tabindex="1" >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" style="font-size: 18px !important;">ราคาทั้งหมด : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtSumprice" name="txtSumprice" readonly>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-dismiss="modal" onclick="resetNewform();">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">ยกเลิก</span>
                                </button>

                                <button type="submit" class="btn btn-success ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">บันทึก</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade text-left" id="modalMedPHRUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h5 class="modal-title white" id="myModalLabel110"><i class="bx bxs-user-plus"></i> เพิ่มยา</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"  onclick="resetDrugform();">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <form id="newdruflistFormU2" onsubmit="return false;">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-4 dn">
                                        <input type="text" id="txtuSeq" name="txtuSeq" value="<?php if($service_found){ echo $service_data['service_seq']; } ?>">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">Patient ID : <span class="text-danger">*</span>  </label>
                                            <input type="text" class="form-control" id="txtuPid" name="txtuPid" readonly value="<?php echo $patient_id; ?>">
                                        </div>
                                    </div>
                                    <div class="col-4 dn">
                                        <div class="form-group dn">
                                            <label for="" style="font-size: 18px !important;">ID : <span class="text-danger">*</span>  </label>
                                            <input type="text" class="form-control" id="txtuDid" name="txtuDid" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">ID : <span class="text-danger">*</span>  </label>
                                            <input type="text" class="form-control" id="txtuDrugId" name="txtuDrugId" readonly>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">ชื่อยา : <span class="text-danger">*</span>  </label>
                                            <input type="text" class="form-control" id="txtuDrugTrade" readonly name="txtuDrugTrade">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6 dn">
                                        <label for="" style="font-size: 18px !important;">ราคาทุน : <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="txtuDrugCost" readonly name="txtuDrugCost" step="0.5" min="0" >
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="" style="font-size: 18px !important;">ราคาขาย : <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="txtuDrugPrice" readonly name="txtuDrugPrice" step="0.5" min="0" >
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="" style="font-size: 18px !important;">จำนวนหน่วย : <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="txtuDrugUnit" name="txtuDrugUnit" step="0.5" min="0" tabindex="1" >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" style="font-size: 18px !important;">ราคาทั้งหมด : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtuSumprice" name="txtuSumprice" readonly>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-dismiss="modal" onclick="resetNewform();">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">ยกเลิก</span>
                                </button>

                                <button type="submit" class="btn btn-success ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">บันทึก</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade text-left" id="modalMedPHRQuick" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h5 class="modal-title white" id="myModalLabel110"><i class="bx bxs-user-plus"></i> เพิ่มยา</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"  onclick="resetDrugform();">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <form id="newdruflistFormQ2" onsubmit="return false;">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-6 dn">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">Seqence ID : <span class="text-danger">*</span>  </label>
                                            <input type="text" id="txtqSeq" name="txtqSeq" class="form-control" value="<?php if($service_found){ echo $service_data['service_seq']; } ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6 dn">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">Patient ID : <span class="text-danger">*</span>  </label>
                                            <input type="text" class="form-control" id="txtqPid" name="txtqPid" readonly value="<?php echo $patient_id; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 dn">
                                        <div class="form-group ">
                                            <label for="" style="font-size: 18px !important;">ID : <span class="text-danger">*</span>  </label>
                                            <input type="text" class="form-control" id="txtqDid" name="txtqDid" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">รหัสยา : <span class="text-danger">*</span>  </label>
                                            <input type="text" class="form-control" id="txtqDrugId" name="txtqDrugId" maxlength="3" size="3">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">ชื่อยา : <span class="text-danger">*</span>  </label>
                                            <input type="text" class="form-control" id="txtqDrugTrade" readonly name="txtqDrugTrade">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6 dn">
                                        <label for="" style="font-size: 18px !important;">ราคาทุน : <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="txtqDrugCost" readonly name="txtqDrugCost" step="0.5" min="0" >
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="" style="font-size: 18px !important;">ราคาขาย : <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="txtqDrugPrice" readonly name="txtqDrugPrice" step="0.5" min="0" >
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="" style="font-size: 18px !important;">จำนวนหน่วย : <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="txtqDrugUnit" name="txtqDrugUnit" step="0.5" min="0" tabindex="1" >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" style="font-size: 18px !important;">ราคาทั้งหมด : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtqSumprice" name="txtqSumprice" readonly>
                                </div>
                            </div>
                            <div class="modal-footer dn">
                                <button type="button" class="btn btn-light-secondary" data-dismiss="modal" onclick="resetNewform();">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">ยกเลิก</span>
                                </button>

                                <button type="submit" class="btn btn-success ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade text-left" id="modalFinallize" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title white" id="myModalLabel110"><i class="bx bx-dollar"></i> สรุปผลเมื่อรับเงิน</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"  onclick="resetDrugform();">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <form id="summarizeForm" onsubmit="return false;">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-6 dn=">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">Sequence ID : <span class="text-danger">*</span>  </label>
                                            <input type="text" id="txtfSeq" name="txtfSeq" class="form-control" value="<?php if($service_found){ echo $service_data['service_seq']; } ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6 dn=">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">Patient ID : <span class="text-danger">*</span>  </label>
                                            <input type="text" class="form-control" id="txtfPid" name="txtfPid" readonly value="<?php echo $patient_id; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">ราคาทุน : <span class="text-danger">*</span>  </label>
                                            <input type="number" class="form-control" id="txtfCose" name="txtfCost" min="0" readonly step="any">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">ราคารวม : <span class="text-danger">*</span>  </label>
                                            <input type="number" class="form-control" id="txtfPrice" name="txtfPrice" min="0" step="any">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">DF. : <span class="text-danger">*</span>  </label>
                                            <input type="number" class="form-control" id="txtfDf" name="txtfDf" min="0" placeholder="DF." step="any" value="<?php if($service_found){ echo $service_data['service_df']; } ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">รวมทั้งสิ้น : <span class="text-danger">*</span>  </label>
                                            <input type="number" class="form-control" id="txtfTotal" name="txtfTotal" min="0" placeholder="TOTAL" step="any" value="<?php if($service_found){ echo $service_data['service_total']; } ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="" style="font-size: 18px !important;">ราคาเรียกเก็บจริง : <span class="text-danger">*</span>  </label>
                                            <input type="number" class="form-control" id="txtfTotal_real" name="txtfTotal_real" min="0" placeholder="" step="any" value="<?php if($service_found){ echo $service_data['service_finalprice']; } ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12 col-sm-6">
                                        <label for="" style="font-size: 18px !important;">ประเภทบริการ : <span class="text-danger">*</span></label>
                                        <select name="txtSertype" id="txtSertype" class="form-control">
                                            <option value="">-- เลือก --</option>
                                            <option value="ตรวจ" <?php if($service_found){ if($service_data['service_type'] == 'ตรวจ'){ echo "selected"; } } ?>>ตรวจรักษา</option>
                                            <option value="ซื้อยา" <?php if($service_found){ if($service_data['service_type'] == 'ซื้อยา'){ echo "selected"; } } ?>>ซื้อยา</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-sm-6">
                                        <label for="" style="font-size: 18px !important;">จ่ายด้วย : <span class="text-danger">*</span></label>
                                        <select name="txtPtype" id="txtPtype" class="form-control">
                                            <option value="">-- เลือก --</option>
                                            <option value="0" <?php if($service_found){ if($service_data['service_paytype'] == '0'){ echo "selected"; } } ?> >เงินสด</option>
                                            <option value="1" <?php if($service_found){ if($service_data['service_paytype'] == '1'){ echo "selected"; } } ?> >โอนเงินผ่านธนาคาร / พร้อมเพย์</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                     <div class="col-12 col-sm-6">
                                        <button type="button" class="btn btn-secondary btn-block btn-lg" onclick="finishServiceWait()">บันทึกและรอการชำระเงิน</button>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <button type="button" class="btn btn-success btn-block btn-lg" onclick="finishService()">บันทึกและจบรายการ</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            

            <!-- <div class="modal fade" id="modalAppointment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-secondary">
                            <h5 class="modal-title text-white" id="exampleModalCenterTitle">เพิ่มนัดหมาย</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="">วันที่นัด : <span class="text-danger">*</span></label>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control pickadate" placeholder="Select Date" id="txtAppDate">
                                <div class="form-control-position" style="padding-top: 8px;">
                                    <i class='bx bx-calendar'></i>
                                </div>
                            </fieldset>


                            <label for="">เวลา : </label>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="text" id="txtAppTime" name="txtAppTime" class="form-control pickatime" placeholder="Select Time">
                                <div class="form-control-position" style="padding-top: 8px;">
                                    <i class='bx bx-history'></i>
                                </div>
                            </fieldset>

                            <div class="form-group">
                                <label for="">สถานที่นัด : <span class="text-danger">*</span></label>
                                <select name="txtAppPlace" id="txtAppPlace" class="form-control">
                                    <option value="">-- เลือกสถานที่นัด --</option>
                                    <option value="clinic">(1) คลินิก</option>
                                    <option value="hospital">(2) โรงพยาบาลสงขลานครินทร์</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">รายละเอียด : <span class="text-muted">(ถ้ามี)</span></label>
                                <textarea name="txtAppInfo" id="txtAppInfo" cols="30" rows="10" style="height: 100px;" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">ยกเลิก</span>
                            </button>
                            <button type="button" class="btn btn-danger ml-1" onclick="saveApp()">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">บันทึกนัดหมาย</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="modal fade" id="modalAppointment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-secondary">
                            <h5 class="modal-title text-white" id="exampleModalCenterTitle">เพิ่มนัดหมาย</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-11">
                                    <label for="">ใส่จำนวนวัน : </label>
                                    <fieldset class="form-group position-relative">
                                        <input type="number" class="form-control" placeholder="1 - 999" id="txtNumDate" min="0" max="999">
                                    </fieldset>
                                </div>
                                <div class="col-1 text-left pl-0" style="padding-top: 18px;">
                                    <button class="btn btn-icon rounded-circle btn-outline-success" onclick="service.calculateAppDate()" style="height: 40px; width: 40px; padding-top: 3px; margin-bottom: 3px;" ><i class="bx bxs-calculator"></i></button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-11">
                                    <label for="">ใส่จำนวนสัปดาห์ : </label>
                                    <fieldset class="form-group position-relative">
                                        <input type="number" class="form-control" placeholder="1 - 99" id="txtNumWeek" min="0" max="999">
                                    </fieldset>
                                </div>
                                <div class="col-1 text-left pl-0" style="padding-top: 18px;">
                                <button class="btn btn-icon rounded-circle btn-outline-success" onclick="service.calculateAppWeek()" style="height: 40px; width: 40px; padding-top: 3px; margin-bottom: 3px;" ><i class="bx bxs-calculator"></i></button>
                                </div>
                            </div>

                            <label for="">วันที่นัด : <span class="text-danger">*</span></label>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control pickadate" placeholder="Select Date" id="txtAppDate">
                                <div class="form-control-position" style="padding-top: 8px;">
                                    <i class='bx bx-calendar'></i>
                                </div>
                            </fieldset>


                            <label for="">เวลา : </label>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="text" id="txtAppTime" name="txtAppTime" class="form-control pickatime" placeholder="Select Time">
                                <div class="form-control-position" style="padding-top: 8px;">
                                    <i class='bx bx-history'></i>
                                </div>
                            </fieldset>

                            <div class="form-group">
                                <label for="">สถานที่นัด : <span class="text-danger">*</span></label>
                                <select name="txtAppPlace" id="txtAppPlace" class="form-control">
                                    <option value="">-- เลือกสถานที่นัด --</option>
                                    <option value="clinic">(1) คลินิก</option>
                                    <option value="hospital">(2) โรงพยาบาลสงขลานครินทร์</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">รายละเอียด : <span class="text-muted">(ถ้ามี)</span></label>
                                <textarea name="txtAppInfo" id="txtAppInfo" cols="30" rows="10" style="height: 100px;" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">ยกเลิก</span>
                            </button>
                            <button type="button" class="btn btn-danger ml-1" onclick="saveApp()">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">บันทึกนัดหมาย</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="content-body row">
                
                <div class="col-6">
                <div class="card">
                        <div class="card-header text-dark">
                            <h4 class="">ประวัติการรักษา/ใช้บริการ</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table th table-striped mb-0 mt-0  dataex-html5-selectors" style="margin-top: 40px;">
                                    <thead>
                                        <tr style="font-size: 1.6em;">
                                            <th style="width: 200px;" class="text-dark- th">วันที่</th>
                                            <th class="text-white- th">รายละเอียด</th>
                                            <th class="text-white- th" style="width: 100px;">บริการ</th>
                                            <th class="text-white- th" style="width: 200px;">จำนวนเงินทั้งหมด</th>
                                            <th class="text-white- th" style="width: 200px;">จำนวนเงินคิดจริง</th>
                                            <th style="width: 120px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $strSQL = "SELECT * FROM bnc_service WHERE service_patient_id = '$patient_id' AND service_delete = '0' ORDER BY service_cdatetime DESC";
                                        // if($service_found){
                                        //     $strSQL = "SELECT * FROM bnc_service WHERE service_patient_id = '$patient_id' AND service_delete = '0' AND service_id = '$service_id' ORDER BY service_cdatetime DESC";
                                        // }
                                        $resService = $db->fetch($strSQL, true, false);
                                        if(($resService) && ($resService['status'])){
                                            foreach ($resService['data'] as $row) {
                                                ?>
                                                <tr>
                                                    <td style="vertical-align: top;"><?php echo $row['service_cdatetime']; ?></td>
                                                    <td style="vertical-align: top;">
                                                        <label for="" class="text-muted">บันทึกการรักษา : </label>
                                                        <div>
                                                            <?php 
                                                            if(($row['service_doctornote'] == NULL) || ($row['service_doctornote']=='<p><br></p>')){
                                                                echo "-";
                                                            }else{
                                                                echo $row['service_doctornote'];
                                                            } 
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td style="vertical-align: top;">
                                                        <div>
                                                            <?php 
                                                            if($row['service_type'] == 'ตรวจ'){
                                                                ?>
                                                                <span class="badge badge-light-primary round" style="margin-bottom: 5px;">ผู้ป่วยตรวจ</span>
                                                                <?php
                                                            }else if($row['service_type'] == 'ซื้อยา'){
                                                                ?>
                                                                <span class="badge badge-light-success round" style="margin-bottom: 5px;">ซื้อยา</span>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <span class="badge badge-light-secondary round" style="margin-bottom: 5px;">ไม่ระบุ</span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div>
                                                            <?php 
                                                            if($row['service_status'] == 'discharge'){
                                                                ?>
                                                                <span class="badge badge-success round " style="margin-bottom: 5px;">เก็บเงินแล้ว</span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td style="vertical-align: top;"><?php echo $row['service_total']; ?></td>
                                                    <td style="vertical-align: top;"><?php echo $row['service_finalprice']; ?></td>
                                                    <td style="vertical-align: top;" class="text-right pl-1">
                                                    <button class="btn btn-icon rounded-circle btn-success" style="height: 40px; width: 40px; padding-top: 1px; margin-bottom: 3px;" onclick="window.location='app-viewrecord.php?patient_id=<?php echo $patient_id?>&service_id=<?php echo $row['service_id']; ?>'"><i class="bx bx-search" style="font-size: 1.3em;"></i></button>
                                                            <button class="btn btn-icon rounded-circle btn-danger" style="height: 40px; width: 40px; padding-top: 1px;" onclick="service.delete('<?php echo $row['service_id']; ?>')"><i class="bx bx-trash" style="font-size: 1.3em;"></i></button>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    ยังไม่มีประวัติการใช้บริการ
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="col-6">

                    <div class="card">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-7 pl-3 pr-3 pt-2"><h4 class="">รายการนัดหมายครั้งต่อไป</h4></div>
                                <div class="col-5">
                                    <div class="pl-2 pt-2 pr-2 text-right">
                                        <button class="btn btn-secondary round " data-toggle="modal" data-target="#modalAppointment" >เพิ่มนัดหมาย</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped mb-0 th">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">
                                            
                                        </th>
                                        <th style="width: 160px;" class="th">วันที่</th>
                                        <th class="th">รายละเอียดการนัดกมาย</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $strSQL = "SELECT * FROM bnc_appointment WHERE app_patient_id = '$patient_id' AND app_date >= '$date' AND app_delete = 'N' ORDER BY app_date ASC";
                                    $resApp = $db->fetch($strSQL, true, false);
                                    if(($resApp) && ($resApp['status'])){
                                        foreach($resApp['data'] as $row){
                                            ?>
                                            <tr>
                                                <td style="vertical-align: top;">
                                                    <a href="Javascript:service.deleteApp('<?php echo $row['app_id'];?>')" class="text-danger"><i class="bx bx-trash"></i></a>
                                                </td>
                                                <td style="vertical-align: top;"><?php echo $row['app_date']; ?></td>
                                                <td style="vertical-align: top;">
                                                    <?php 
                                                    echo "สถานที่ : ".$row['app_place']."<br>";
                                                    echo "รายละเอียด : ";
                                                    if($row['app_info'] == ''){
                                                        echo "-";
                                                    }else{
                                                        echo $row['app_info'];
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }else{
                                        ?>
                                        <tr>
                                            <td colspan="3" class="text-center th">ไม่มีบันทึกการนัดหมาย</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <?php 
                    if($service_found){
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <h4>บันทึกการรักษา</h4>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="snow-wrapper">
                                            <div id="snow-container">
                                                <div id="quillEditor">
                                                    <?php if($service_found){ echo $service_data['service_doctornote'];} ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-0" style="border: solid; border-width: 1px 0px 0px 0px; border-color: #f4f4f4;">
                                <div style="padding: 30px;">
                                    <div class="row">
                                        <div class="col-12"><h4 class="">รายการยา</h4></div>
                                        <div class="col-12 text-left">
                                            <a href="Javascript:void(0)" onclick="openQuickAdd()" class="btn round btn-secondary btn-sm-">เพิ่มรายการอย่างรวดเร็ว</a>
                                            <a href="Javascript:void(0)" data-toggle="modal" data-target="#modalDruglist" class="btn round btn-secondary btn-sm-">ดูรายการยา</a>
                                            <a href="Javascript:void(0)" data-toggle="modal" data-target="#modalAddOther" class="btn round btn-secondary btn-sm-" onclick="focusOther()">เพิ่มรายการอื่น ๆ</a>

                                            <div class="modal fade" id="modalDruglist" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-success">
                                                            <!-- <h5 class="modal-title text-white" id="exampleModalCenterTitle">รายชื่อยา</h5> -->
                                                            <input type="text" class="form-control" style="width: 300px; border-radius: 30px;" placeholder="พิมพ์ชื่อยาเพื่อค้นหา ..."">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <i class="bx bx-x"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body p-0">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr style="background: #4a5751; font-weight: 400; color: #fff;">
                                                                        <td style="width: 50px;" class="pl-1 pr-1">ID</td>
                                                                        <td>Drug name</td>
                                                                        <td>ราคาทุน</td>
                                                                        <td>ราคาขาย</td>
                                                                        <td style="width: 50px;"></td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php 
                                                                $strSQL = "SELECT * FROM bnc_drug_tmp WHERE ddelete = '0'";
                                                                $result = $db->fetch($strSQL, true);
                                                                if($result['status']){
                                                                    $c = 1;
                                                                    foreach ($result['data'] as $row) {
                                                                        ?>
                                                                        <tr>
                                                                            <td class="pl-1 pr-1" id="ddid_<?php echo $row['ID']; ?>"><?php echo $row['did'];?></td>
                                                                            <td id="dname_<?php echo $row['ID']; ?>"><?php echo $row['dname'];?><br><small><?php echo $row['dcname'];?></small><br><small>Dose : <?php echo $row['ddose'];?></small></td>
                                                                            <td id="dcost_<?php echo $row['ID']; ?>"><?php echo $row['dcost'];?></td>
                                                                            <td id="dprince_<?php echo $row['ID']; ?>"><?php echo $row['dprice'];?></td>
                                                                            <td class="text-right" style="width: 50px; padding-right: 30px !important;">
                                                                                <button class="btn btn-icon rounded-circle btn-outline-success" onclick="addNewmed('<?php echo $row['ID']; ?>')" style="height: 40px; width: 40px; padding-top: 1px; margin-bottom: 3px;" ><i class="bx bx-plus"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="modalAddOther" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-success">
                                                            <h5 class="modal-title text-white" id="exampleModalCenterTitle">เพิ่มรายการอื่น ๆ</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetOtherForm()">
                                                                <i class="bx bx-x"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            
                                                            <div class="form-group">
                                                                <label for="" style="font-size: 18px !important;">รายการ / รายละเอียด : <span class="text-danger">*</span></label>
                                                                <textarea name="txtOtheritem" id="txtOtheritem" cols="30" rows="10" class="form-control" style="height: 100px;"></textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="" style="font-size: 18px !important;">ราคา : <span class="text-danger">*</span></label>
                                                                <input type="number" class="form-control" id="txtOthercost">
                                                            </div>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal" onclick="resetOtherForm()">
                                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                                <span class="d-none d-sm-block">ยกเลิก</span>
                                                            </button>
                                                            <button type="button" class="btn btn-primary ml-1" onclick="saveOterDrug()">
                                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                                <span class="d-none d-sm-block">บันทึก</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <table class="table mt-0 teble-striped">
                                        <thead>
                                            <tr>
                                                <th>รหัส</th>
                                                <th>ชื่อยา</th>
                                                <th>ราคาขายต่อหน่วย</th>
                                                <th>จำนวน</th>
                                                <th>ทุนรวม</th>
                                                <th>รวม</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="drugList">
                                            <tr>
                                                <td colspan="6" class="text-center">ไม่มีรายการยาสำหรับบริการครั้งนี้</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>

                            <div class="card-body" style="border: solid; border-width: 1px 0px 0px 0px; border-color: #f4f4f4;">
                                <div>
                                    <div class="row">
                                        <div class="col-12 pt-1"><h2>รวมทั้งสิ้น (บาท)</h2></div>
                                        <div class="form-group  col-6 text-right">
                                            <label for="">รวมราคาทุน : </label>
                                            <input type="number" min="0" id="txtFinalCost" class="form-control text-right mr-1" style="font-size: 2em;" placeholder="ทุนรวม" readonly>
                                        </div>
                                        <div class="col-6 text-right">
                                            <label for="">รวมราคาขาย : </label>
                                            <input type="number" min="0" id="txtFinalPrice" class="form-control text-right" style="font-size: 2em;">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-right pt-2">
                                            <!-- <button class="btn btn-danger- btn-lg btn-block-">ล้างรายการทั้งหมด</button> -->
                                            <button class="btn btn-danger btn-lg btn-block" onclick="finallizeService()">จบรายการและคิดเงิน</button>                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                

                
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <!-- demo chat-->
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>



    <!-- BEGIN: Vendor JS-->
    <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../../../app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/polyfill.min.js"></script>
    <script src="../../../node_modules/preload.js/dist/js/preload.js"></script>
    <script src="../../../app-assets/vendors/js/editors/quill/katex.min.js"></script>
    <script src="../../../app-assets/vendors/js/editors/quill/highlight.min.js"></script>
    <script src="../../../app-assets/vendors/js/editors/quill/quill.min.js"></script>
    
    <script src="../../../app-assets/vendors/js/pickers/pickadate/picker.js"></script>
    <script src="../../../app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
    <script src="../../../app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
    <script src="../../../app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/moment.min.js"></script>
    <script src="../../../app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../../../app-assets/js/scripts/configs/horizontal-menu.js"></script>
    <script src="../../../app-assets/js/core/app-menu.js"></script>
    <script src="../../../app-assets/js/core/app.js"></script>
    <script src="../../../app-assets/js/scripts/components.js"></script>
    <script src="../../../app-assets/js/scripts/footer.js"></script>

    <script src="../../../app-assets/js/scripts/editors/editor-quill.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="../../../assets/js/banchaclinic/core.js?v=<?php echo filemtime('../../../assets/js/banchaclinic/core.js'); ?>"></script>
    <script src="../../../assets/js/banchaclinic/patient.js?v=<?php echo filemtime('../../../assets/js/banchaclinic/patient.js'); ?>"></script>
    <script src="../../../assets/js/banchaclinic/drug.js?v=<?php echo filemtime('../../../assets/js/banchaclinic/drug.js'); ?>"></script>
    <script src="../../../assets/js/banchaclinic/service.js?v=<?php echo filemtime('../../../assets/js/banchaclinic/service.js'); ?>"></script>
    <!-- END: Page JS-->

    <script>

        var quill = null;
        $(document).ready(function(){

            preload.hide()
            var options = {
                placeholder: 'Waiting for your precious content',
                theme: 'snow'
                
            };

            quill = new Quill('#quillEditor', options);

            getDruglist();
            $('.pickadate').pickadate({
                format: 'yyyy-mm-dd',
                holder: 'เลือกวันที่ต้องการนัด',
                // selectYears: true,
                selectMonths: true,
                selectYears: 2,
                min: 0,
            });

            $('.pickatime').pickatime({
                format: 'HH:i',
                formatSubmit: 'HH:i',
                hiddenSuffix: '_submit',
                hiddenName: true,
                min: [6,30],
                max: [20,0]           
            });

            if(($('#txtServiceId').val() != '') && ($('#txtPatientId').val() != '')){
                console.log($('#txtServiceId').val());
                console.log($('#txtSeq').val());
                getDruglist()
            }

        })

        $(function(){
            $('.form-control').focus(function(){
                $(this).removeClass('is-invalid')
            })

            $('#searchForm').keyup(function(){
                if($('#txtSearchkey').val() != ''){
                    $('#txtSearchkey').removeClass('is-invalid')
                    return ;
                }
            })

            $('#searchForm').submit(function(){
                if($('#txtSearchkey').val() == ''){
                    $('#txtSearchkey').addClass('is-invalid')
                    return ;
                }
                window.location = './app-cashing.php?searchkey=' + $('#txtSearchkey').val()
            })
        })
    </script>

</body>
<!-- END: Body-->

</html>