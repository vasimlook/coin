<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?php echo ASSETS_DIR_LINK; ?>images/favicon.png">
    <!-- Page Title  -->
    <title><?php echo $title; ?></title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?php echo ASSETS_DIR_LINK; ?>template/assets/css/dashlite.css">
    <link id="skin-default" rel="stylesheet" href="<?php echo ASSETS_DIR_LINK; ?>template/assets/css/theme.css"> 
    <link id="skin-default" rel="stylesheet" href="<?php echo ASSETS_DIR_LINK; ?>template/assets/css/<?php echo $_SESSION['theme_color']; ?>.css">
    <style>
        body {
            color: #fff;
            background: linear-gradient(135deg, #602b63, #5136a3, #ff0000);
            animation: gradientMove 8s ease infinite;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .custom-divider {
            padding-top: 10px;
            padding-bottom: 10px;
            display: flex;
            align-items: center;            
            text-align: center;
        }

        .custom-divider::before,
        .custom-divider::after {
            content: "";
            flex: 1;
            height: 5px;
            background: linear-gradient(to right, transparent, #5a7dc2);
        }

        .custom-divider::after {
            background: linear-gradient(to left, transparent, #5a7dc2);
        }

        .custom-divider span {
            padding: 0 10px;
            color: #000;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }

        /* ====== Card (Glassmorphism) ====== */
        .card {
            /* border: 2px solid; */
            background: rgba(255, 255, 255, 0.08) !important;
            backdrop-filter: blur(12px) !important;
            /* border-radius: 20px !important; */
            box-shadow: 0 0 30px rgb(16 16 16 / 39%) !important;
            color: white !important;
            max-width: 420px !important;
            width: 100% !important;
            padding: 15px !important;
        }

        /* ====== Inner Card Spacing ====== */
        .card-inner-lg {
            padding: 20px 10px !important;
        }

        /* ====== Headings ====== */
        h4.nk-block-title {
            font-weight: 600 !important;
            text-align: center !important;
            color: #fff !important;
        }

        /* ====== Inputs ====== */
        .form-control {
            background: rgba(255, 255, 255, 0.15) !important;
            border: none !important;
            color: #fff !important;
            border-radius: 8px !important;
        }

        .form-control::placeholder {
            color: #ddd !important;
        }

        /* ====== Buttons ====== */
        .btn-primary {
            background: linear-gradient(45deg, #ff0057, #ff7f50) !important;
            border: none !important;
            font-weight: bold !important;
            transition: 0.3s !important;
        }

        .btn-primary:hover {
            transform: scale(1.05) !important;
        }

        .btn-danger {
            background: linear-gradient(45deg, #8a2387, #e94057, #f27121) !important;
            border: none !important;
            font-weight: bold !important;
        }

        .btn-danger:hover {
            transform: scale(1.05) !important;
        }

        /* ====== Divider ====== */
        .custom-divider {
            display: flex !important;
            align-items: center !important;
            text-align: center !important;
            margin: 10px 0 !important;
        }

        .custom-divider::before,
        .custom-divider::after {
            content: "" !important;
            flex: 1 !important;
            height: 2px !important;
            background: linear-gradient(to right, transparent, #ff416c, #ff4b2b) !important;
        }

        .custom-divider::after {
            background: linear-gradient(to left, transparent, #ff416c, #ff4b2b) !important;
        }

        .custom-divider span {
            padding: 0 10px !important;
            font-weight: bold !important;
            color: #fff !important;
        }
    </style>
</head>

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="<?php echo BASE_URL; ?>" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="<?php echo ASSETS_DIR_LINK; ?>template/images/logo.png" srcset="<?php echo ASSETS_DIR_LINK; ?>template/images/logo2x.png 2x" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="<?php echo ASSETS_DIR_LINK; ?>template/images/logo-dark.png" srcset="<?php echo ASSETS_DIR_LINK; ?>template/images/logo-dark2x.png 2x" alt="logo-dark">
                            </a>
                        </div>
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Forgot password</h4>
                                        <hr>
                                    </div>
                                </div> 
                                <?php
                                    $attributes = ['id' => 'forgot_password', 'name' => 'forgot_password'];                                                                          
                                    echo form_open(USER_FORGET_PWD_LINK,$attributes);
                                ?> 
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control form-control-lg" id="default-01" name="mobileno" placeholder="Enter mobile number">
                                            <p class="text-danger"><?php if(isset($errors['mobileno'])) { echo $errors['mobileno']; } ?></p>
                                        </div>
                                    </div>
                                    <div class="form-group pt-2">
                                        <button class="btn btn-lg btn-primary btn-block" id="btnSubmit">Send OTP</button>
                                    </div>
                                <?php echo form_close();?>
                                <div class="custom-divider"><span>Or</span></div>
                                <div class="form-note-s2 text-center">
                                    <a class="text-primary" href="<?php echo USER_LOGIN_LINK; ?>"><strong>Return to login</strong></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="<?php echo ASSETS_DIR_LINK; ?>template/assets/js/bundle.js"></script>
    <script src="<?php echo ASSETS_DIR_LINK; ?>template/assets//js/scripts.js"></script>
    <?php include(APPPATH . "Views/notify.php"); ?>
</body>

</html>