<?php 

require('../../../../../database_config/banchaclinic/config.inc.php');
require('../../../configuration/configuration.php');
require('../../../configuration/database.php'); 
require('../../../configuration/session.php'); 

$db = new Database();
$conn = $db->conn();

require('../../../configuration/user.inc.php'); 

$page_id = 0;
?>
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
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/semi-dark-layout.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/widgets.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/dashboard-analytics.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css?v=<?php echo filemtime('../../../assets/css/style.css'); ?>">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

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
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" id="btnFullscreen"><i class="ficon bx bx-fullscreen"></i></a></li>
                        <li class="nav-item nav-search"><a class="nav-link nav-link-search pt-2"><i class="ficon bx bx-search"></i></a>
                            <div class="search-input">
                                <div class="search-input-icon"><i class="bx bx-search primary"></i></div>
                                <input class="input" type="text" placeholder="Explore Frest..." tabindex="-1" data-search="template-search">
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
            </div>
            <div class="content-body">
                <!-- Dashboard Analytics Start -->
                <section id="dashboard-analytics">
                    <div class="row">
                        <!-- Website Analytics Starts-->
                        <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                                    <h4 class="card-title text-white">จำนวนครั้งการเข้ารับบริการ  (ย้อนหลัง 7 วัน)</h4>
                                </div>
                                <div class="card-body pb-1 pt-3">
                                    <div class="d-flex justify-content-around align-items-center flex-wrap">
                                        <div class="user-analytics mr-2">
                                            <i class="bx bx-user mr-25 align-middle"></i>
                                            <span class="align-middle text-muted">ทั้งหมด</span>
                                            
                                            <?php 
                                            $NService = 0;
                                            $strSQL = "SELECT COUNT(service_id) cn 
                                                        FROM bnc_service 
                                                        WHERE 
                                                        service_delete = '0' 
                                                        AND service_status = 'discharge'
                                                        AND service_patient_id IN (
                                                            SELECT patient_id FROM bcn_patient WHERE patient_delete = '0'
                                                        )
                                                        "; 
                                            $res = $db->fetch($strSQL, false);
                                            if($res){
                                                $NService = $res['cn'];
                                                ?>
                                                <input type="hidden" id="txtServiceAll" value="<?php echo $res['cn']; ?>">
                                                <?php
                                            }else{
                                                ?>
                                                <input type="hidden" id="txtServiceAll" value="0">
                                                <?php
                                            }
                                            ?>
                                            <br>
                                            <small>จากการใช้บริการทั้้งหมด <?php echo $NService; ?> ครั้ง<br>ใน 30 วันล่าสุด</small>
                                            <div class="d-flex">
                                                <div id="radial-success-chart"></div>
                                                <h3 class="mt-1 ml-50" id="">
                                                    <?php 
                                                    $NService7 = 0;
                                                    $last7day = date('Y-m-d', strtotime('-7 days'));
                                                    $strSQL = "SELECT COUNT(service_id) cn 
                                                               FROM bnc_service 
                                                               WHERE 
                                                               service_delete = '0' 
                                                               AND service_date >= '$last7day'
                                                               AND service_status = 'discharge'
                                                               AND service_patient_id IN (
                                                                   SELECT patient_id FROM bcn_patient WHERE patient_delete = '0'
                                                               )
                                                               "; 
                                                    $res = $db->fetch($strSQL, false);
                                                    if($res){
                                                        $NService7 = $res['cn'];
                                                        echo $res['cn'];
                                                        ?>
                                                        <input type="hidden" id="txtServiceN7" value="<?php echo $res['cn']; ?>">
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <input type="hidden" id="txtServiceN7" value="0">
                                                        <?php
                                                    }
                                                    ?>
                                                </h3>
                                            </div>
                                        </div>

                                        <?php 
                                        if($NService != 0){
                                            if($NService7 != 0){
                                                $navg = ($NService7 * 100) / $NService;
                                                ?>
                                                <input type="hidden" id="txtServiceNAvg" value="<?php echo $navg;?>">
                                                <?php
                                            }else{
                                                ?>
                                                <input type="hidden" id="txtServiceNAvg" value="0">
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <input type="hidden" id="txtServiceNAvg" value="0">
                                            <?php
                                        }
                                        ?>
                                        <div class="sessions-analytics mr-2">
                                            <i class="bx bx-trending-up align-middle mr-25"></i>
                                            <span class="align-middle text-muted">ผู้ป่วยตรวจ</span>
                                            <br>
                                            <small>จากจำนวนครั้งการใช้บริการ<br>7 วันล่าสุด</small>
                                            <div class="d-flex">
                                                <div id="radial-warning-chart"></div>
                                                <h3 class="mt-1 ml-50" id="">
                                                    <?php 
                                                    $last7day = date('Y-m-d', strtotime('-7 days'));
                                                    $strSQL = "SELECT COUNT(service_id) cn 
                                                               FROM bnc_service 
                                                               WHERE 
                                                               service_delete = '0' 
                                                               AND service_date >= '$last7day'
                                                               AND service_status = 'discharge'
                                                               AND service_df IS NOT NULL
                                                               AND service_patient_id IN (
                                                                   SELECT patient_id FROM bcn_patient WHERE patient_delete = '0'
                                                               )
                                                               "; 
                                                    $res = $db->fetch($strSQL, false);
                                                    $NService7Df = 0;
                                                    if($res){
                                                        echo $res['cn'];
                                                        $NService7Df = $res['cn'];
                                                        ?>
                                                        <input type="hidden" id="txtServiceDf" value="<?php echo $res['cn'];?>">
                                                        <?php
                                                    }else{
                                                        echo "0";
                                                        ?>
                                                        <input type="hidden" id="txtServiceDf" value="0">
                                                        <?php
                                                    }
                                                    ?>
                                                </h3>
                                            </div>
                                        </div>

                                        <?php 
                                        if($NService7 != 0){
                                            if($NService7Df != 0){
                                                $navg = ($NService7Df * 100) / $NService7;
                                                ?>
                                                <input type="hidden" id="txtServiceDfPct" value="<?php echo $navg;?>">
                                                <?php
                                            }else{
                                                ?>
                                                <input type="hidden" id="txtServiceDfPct" value="0">
                                                <?php
                                            }
                                            
                                        }else{
                                            ?>
                                            <input type="hidden" id="txtServiceDfPct" value="0">
                                            <?php
                                        }
                                        ?>
                                        <div class="bounce-rate-analytics">
                                            <i class="bx bx-pie-chart-alt align-middle mr-25"></i>
                                            <span class="align-middle text-muted">ผู้ป่วยไม่ตรวจ</span>
                                            <br>
                                            <small>จากจำนวนครั้งการใช้บริการ<br>7 วันล่าสุด</small>
                                            <div class="d-flex">
                                                <div id="radial-danger-chart"></div>
                                                <h3 class="mt-1 ml-50" id="">
                                                <?php 
                                                    $last7day = date('Y-m-d', strtotime('-7 days'));
                                                    $strSQL = "SELECT COUNT(service_id) cn 
                                                               FROM bnc_service 
                                                               WHERE 
                                                               service_delete = '0' 
                                                               AND service_date >= '$last7day'
                                                               AND service_status = 'discharge'
                                                               AND service_df IS NULL
                                                               AND service_patient_id IN (
                                                                   SELECT patient_id FROM bcn_patient WHERE patient_delete = '0'
                                                               )
                                                               "; 
                                                    $res = $db->fetch($strSQL, false);
                                                    $NService7nDf = 0;
                                                    if($res){
                                                        $NService7nDf = $res['cn'];
                                                        echo $res['cn'];
                                                        ?>
                                                        <input type="hidden" id="txtServiceNDf" value="<?php echo $res['cn'];?>">
                                                        <?php
                                                    }else{
                                                        echo "0";
                                                        ?>
                                                        <input type="hidden" id="txtServiceNDf" value="0">
                                                        <?php
                                                    }
                                                    ?>
                                                </h3>
                                            </div>

                                            <?php 
                                            if($NService7 != 0){
                                                if($NService7nDf != 0){
                                                    $navg = ($NService7nDf * 100) / $NService7;
                                                    ?>
                                                    <input type="hidden" id="txtServicenDfPct" value="<?php echo $navg;?>">
                                                    <?php
                                                }else{
                                                    ?>
                                                    <input type="hidden" id="txtServicenDfPct" value="0">
                                                    <?php
                                                }
                                                
                                            }else{
                                                ?>
                                                <input type="hidden" id="txtServicenDfPct" value="0">
                                                <?php
                                            }
                                            ?>
                                            
                                        </div>
                                    </div>
                                    <div id="analytics-bar-chart" class="my-75"></div>
                                </div>
                            </div>


                            <div class="row">
                                <!-- Referral Chart Starts-->
                                <div class="col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-body text-center pb-0">
                                            <span class="text-muted">รายได้ทั้งหมด (ย้อนหลัง 30 วัน)</span>
                                            <h2>
                                                <?php 
                                                $last7day = date('Y-m-d', strtotime('-30 days'));
                                                $strSQL = "SELECT SUM(service_total) total 
                                                           FROM bnc_service 
                                                           WHERE 
                                                           service_delete = '0' 
                                                           AND service_date >= '$last7day'
                                                           AND service_status = 'discharge'
                                                           AND service_patient_id IN (
                                                               SELECT patient_id FROM bcn_patient WHERE patient_delete = '0'
                                                           )
                                                           "; 
                                                $res = $db->fetch($strSQL, false);
                                                if($res){
                                                    echo number_format($res['total'], '2', '.', ','). " บาท";
                                                }else{
                                                    echo "0";
                                                }
                                                ?>
                                            </h2>
                                            
                                            <div id="success-line-chart"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Impression Radial Chart Starts-->
                                <div class="col-xl-6 col-12">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <h4 class="card-title">รายงานรายได้ (ย้อนหลัง 30 วัน)</h4>
                                                </div>
                                                <div class="card-body d-flex justify-content-around">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="d-inline-flex mr-xl-2">
                                                                <div id="profit-primary-chart"></div>
                                                                <div class="profit-content ml-50 mt-50">
                                                                    <small class="text-muted">ต้นทุน</small>
                                                                    <h5 class="mb-0">
                                                                    <?php 
                                                                    $last7day = date('Y-m-d', strtotime('-30 days'));
                                                                    $strSQL = "SELECT SUM(service_cost) total 
                                                                            FROM bnc_service 
                                                                            WHERE 
                                                                            service_delete = '0' 
                                                                            AND service_date >= '$last7day'
                                                                            AND service_status = 'discharge'
                                                                            AND service_patient_id IN (
                                                                                SELECT patient_id FROM bcn_patient WHERE patient_delete = '0'
                                                                            )
                                                                            "; 
                                                                    $res = $db->fetch($strSQL, false);
                                                                    $cost = 0;
                                                                    if($res){
                                                                        $cost = $res['total'];
                                                                        echo number_format($res['total'], '2', '.', ','). " บาท";
                                                                    }else{
                                                                        echo "0";
                                                                    }
                                                                    ?>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="d-inline-flex">
                                                                <div id="profit-info-chart"></div>
                                                                <div class="profit-content ml-50 mt-50">
                                                                    <small class="text-muted">กำไร</small>
                                                                    <h5 class="mb-0">
                                                                    <?php 
                                                                    $last7day = date('Y-m-d', strtotime('-30 days'));
                                                                    $strSQL = "SELECT SUM(service_total) total 
                                                                            FROM bnc_service 
                                                                            WHERE 
                                                                            service_delete = '0' 
                                                                            AND service_date >= '$last7day'
                                                                            AND service_status = 'discharge'
                                                                            AND service_patient_id IN (
                                                                                SELECT patient_id FROM bcn_patient WHERE patient_delete = '0'
                                                                            )
                                                                            "; 
                                                                    $res = $db->fetch($strSQL, false);
                                                                    if($res){
                                                                        echo number_format($res['total'] - $cost, '2', '.', ','). " บาท";
                                                                    }else{
                                                                        echo "0";
                                                                    }
                                                                    ?>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-12 col-md-6 col-sm-6">
                            <div class="card widget-todo">
                                <div class="card-header bg-dark border-bottom d-flex justify-content-between align-items-center flex-wrap">
                                    <h4 class="card-title d-flex mb-25 mb-sm-0 text-white">
                                        <i class='bx bx-check font-medium-5 pl-25 pr-75 text-white'></i>ผู้ป่วยนัดหมายวันนี้
                                    </h4>
                                </div>
                                <div class="card-body px-0 py-1">
                                    <ul class="widget-todo-list-wrapper" id="widget-todo-list">
                                        <?php 
                                        $strSQL = "SELECT * FROM bnc_appointment a INNER JOIN bcn_patient b ON a.app_patient_id = b.patient_id WHERE a.app_date = '$date' AND a.app_status = 'Y' AND a.app_delete = 'N' ORDER BY a.app_date ASC";
                                        $resApp = $db->fetch($strSQL, true, false);
                                        if(($resApp) && ($resApp['status'])){
                                            foreach($resApp['data'] as $row){
                                                ?>
                                                <li class="widget-todo-item" style="cursor: pointer;" onclick="window.location='../../../controller/create_service.php?patient_id=<?php echo $row['patient_id']; ?>'">
                                                    <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                                        <div class="widget-todo-title-area d-flex- align-items-center pl-2">
                                                        <span class="widget-todo-title text-dark" style="font-size: 1.3em;"><?php echo $row['patient_fname']." ".$row['patient_lname']; ?></span>
                                                            <div>
                                                                <?php echo $row['app_date']." ".$row['app_time']; ?>
                                                            </div>
                                                        </div>
                                                        <div class="widget-todo-item-action d-flex align-items-center">
                                                            <?php 
                                                            if($row['app_place'] == 'clinic'){
                                                                ?>
                                                                <div class="badge badge-pill badge-light-primary mr-1">Clinic</div>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <div class="badge badge-pill badge-light-danger mr-1">โรงพยาบาล</div>
                                                                <?php
                                                            }
                                                            ?>
                                                            
                                                            <div class="dropdown">
                                                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-search text-primary mr-1"></i> ดูรายละเอียด</a>
                                                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash text-danger mr-1"></i> ยกเลิกนัด</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <li class="widget-todo-item" style="cursor: pointer;" onclick="window.location='../../../controller/create_service.php?patient_id=<?php echo $row['patient_id']; ?>'">
                                                    <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                                        <div class="text-center p-3">
                                                            ไม่มีผู้ป่วยนัดวันนี้
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header d-flex bg-dark justify-content-between align-items-center">
                                    <div class="card-title-content">
                                        <h4 class="card-title text-white">รายได้ย้อนหลัง 7 วัน</h4>
                                        <small class="text-muted text-white">Calculated in last 7 days</small>
                                    </div>
                                </div>
                                <div class="card-body pt-3">
                                    <div id="sales-chart" class="mb-2"></div>
                                    <!-- <div class="d-flex justify-content-between my-1">
                                        <div class="sales-info d-flex align-items-center">
                                            <i class='bx bx-up-arrow-circle text-primary font-medium-5 mr-50'></i>
                                            <div class="sales-info-content">
                                                <h6 class="mb-0">Best Selling</h6>
                                                <small class="text-muted">Sunday</small>
                                            </div>
                                        </div>
                                        <h6 class="mb-0">28.6k</h6>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <div class="sales-info d-flex align-items-center">
                                            <i class='bx bx-down-arrow-circle icon-light font-medium-5 mr-50'></i>
                                            <div class="sales-info-content">
                                                <h6 class="mb-0">Lowest Selling</h6>
                                                <small class="text-muted">Thursday</small>
                                            </div>
                                        </div>
                                        <h6 class="mb-0">986k</h6>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Dashboard Analytics end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <?php require_once('componants/footer.php'); ?>


    <!-- BEGIN: Vendor JS-->
    <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../../../app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script src="../../../app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/dragula.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../../../app-assets/js/scripts/configs/horizontal-menu.js"></script>
    <script src="../../../app-assets/js/core/app-menu.js"></script>
    <script src="../../../app-assets/js/core/app.js"></script>
    <script src="../../../app-assets/js/scripts/components.js"></script>
    <script src="../../../app-assets/js/scripts/footer.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="../../../app-assets/js/scripts/pages/dashboard-analytics.js?v=<?php echo filemtime('../../../app-assets/js/scripts/pages/dashboard-analytics.js'); ?>"></script>
    <!-- END: Page JS-->

    <!-- BEGIN : BANCHACLINIC -->
    <script src="../../../assets/js/banchaclinic/core.js?v=<?php echo filemtime('../../../assets/js/banchaclinic/core.js'); ?>"></script>
    <script src="../../../assets/js/banchaclinic/authen.js?v=<?php echo filemtime('../../../assets/js/banchaclinic/authen.js'); ?>"></script>
    <!-- END : BANCHACLINIC -->

</body>
<!-- END: Body-->

</html>