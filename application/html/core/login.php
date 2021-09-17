<?php 
require('../../../../database_config/banchaclinic/config.inc.php');
require('../../configuration/configuration.php');
require('../../configuration/database.php'); 

$db = new Database();
$conn = $db->conn();
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['app_title']; ?></title>
    <link rel="apple-touch-icon" href="../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/themes/semi-dark-layout.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/css/pages/authentication.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/vendors/css/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="../../app-assets/vendors/css/extensions/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="../../node_modules/preload.js/dist/css/preload.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu navbar-static 1-column   footer-static bg-full-screen-image  blank-page" data-open="hover" data-menu="horizontal-menu" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- login page start -->
                <section id="auth-login" class="row flexbox-container">
                    <div class="col-xl-8 col-11">
                        <div class="card bg-authentication mb-0">
                            <div class="row m-0">
                                <!-- left section-login -->
                                <div class="col-md-6 col-12 px-0">
                                    <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="text-center mb-2 text-dark" style="font-size: 2em !important;">เข้าสู่ระบบ</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            
                                            <form onsubmit="authen.login(); return false;" method="post" id="loginForm">
                                                <div class="form-group mb-50">
                                                    <label class="text-bold-400 text-dark" for="txtUsername" style="font-size: 18px !important;">ชื่อบัญชีผู้ใช้งาน :</label>
                                                    <input type="text" class="form-control login-input" id="txtUsername" name="txtUsername" style="border-radius: 30px; background: rgb(242, 242, 242);" placeholder="ชื่อบัญชีผู้ใช้งาน" autofocus></div>
                                                <div class="form-group">
                                                    <label class="text-bold-400 text-dark" for="txtPassword" style="font-size: 18px !important;">รหัสผ่าน :</label>
                                                    <input type="password" class="form-control" id="txtPassword" name="txtPassword" style="border-radius: 30px; background: rgb(242, 242, 242);">
                                                </div>
                                                <!-- <button type="button" class="btn btn-success glow w-100 position-relative " onclick="checkLogin()"  style="border-radius: 30px;font-size: 18px !important; padding: 10px 0px;">ล๊อคอิน<i id="icon-arrow-" class="bx bx-right-arrow-alt"></i></button> -->
                                                <button type="submit" class="btn btn-success glow w-100 position-relative "  style="border-radius: 30px; font-size: 18px !important; padding: 10px 0px;">ล๊อคอิน<i id="icon-arrow-" class="bx bx-right-arrow-alt"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- right section image -->
                                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                                    <img class="img-fluid" src="../../app-assets/images/pages/login.png" alt="branding logo">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- login page ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="../../app-assets/vendors/js/vendors.min.js"></script>
    <script src="../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
    <script src="../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
    <script src="../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../../app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script src="../../app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="../../app-assets/vendors/js/extensions/polyfill.min.js"></script>
    <script src="../../node_modules/preload.js/dist/js/preload.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../../app-assets/js/scripts/configs/horizontal-menu.js"></script>
    <script src="../../app-assets/js/core/app-menu.js"></script>
    <script src="../../app-assets/js/core/app.js"></script>
    <script src="../../app-assets/js/scripts/components.js"></script>
    <script src="../../app-assets/js/scripts/footer.js"></script>
    <!-- END: Theme JS-->


    <!-- BEGIN : BANCHACLINIC -->
    <script src="../../assets/js/banchaclinic/core.js"></script>
    <script src="../../assets/js/banchaclinic/authen.js"></script>
    <!-- END : BANCHACLINIC -->

    <!-- BEGIN: Page JS-->
    <script>

        $(document).ready(function(){
            preload.hide()
        })

        $(function(){
            $('.form-control').focus(function(){
                $(this).removeClass('is-invalid')
            })
        })
    </script>
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>