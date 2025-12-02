<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful color game for make big profit">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?php echo ASSETS_DIR_LINK; ?>images/favicon.png">
    <!-- Page Title  -->
    <title><?php echo $title; ?></title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?php echo ASSETS_DIR_LINK; ?>template/assets/css/dashlite.css">
    <link id="skin-default" rel="stylesheet" href="<?php echo ASSETS_DIR_LINK; ?>template/assets/css/theme.css">
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
                    <div class="nk-block nk-block-middle nk-auth-body wide-xs">
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
                                        <h4 class="nk-block-title">Register</h4>
                                        <hr>
                                    </div>
                                </div>                                
                                <?php
                                $attributes = ['id' => 'signup', 'name' => 'signup'];
                                echo form_open(USER_SIGNUP_LINK . $referral_code, $attributes);
                                ?>
                                <div class="form-group mb-2">
                                    <!-- <label class="form-label" for="name">Name</label> -->
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control form-control-lg" name="name" id="name" placeholder="Enter your name" required="" autocomplete="off">
                                        <p class="text-danger"><?php if (isset($errors['name'])) {
                                                                    echo $errors['name'];
                                                                } ?></p>
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <!-- <label class="form-label" for="email">Mobile Number</label> -->
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control form-control-lg" maxlength="10" minlength="10" name="username" placeholder="Enter your mobile no" required="" autocomplete="off">
                                        <p class="text-danger"><?php if (isset($errors['username'])) {
                                                                    echo $errors['username'];
                                                                } ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <!-- <label class="form-label" for="password">Passcode</label> -->
                                    <div class="form-control-wrap">
                                        <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Enter new password" autocomplete="off" required="" autocomplete="off">
                                        <p class="text-danger"><?php if (isset($errors['password'])) {
                                                                    echo $errors['password'];
                                                                } ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <input type="text" name="referral_code" class="form-control form-control-lg" id="referral_code" placeholder="Enter your referal code" required="" autocomplete="off" value="<?php echo @$referral_code; ?>">
                                </div>
                                <!-- <div class="form-group">
                                    <div class="custom-control custom-control-xs custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox">
                                        <label class="custom-control-label" for="checkbox">I agree to <a href="#" class="text-primary">Privacy Policy</a> &amp; <a href="#" class="text-primary"> Terms.</a></label>
                                    </div>
                                </div> -->
                                <div class="form-group pt-2">
                                    <button class="btn btn-lg btn-primary btn-block" id="btnSubmit">Register</button>
                                </div>
                                <?php echo form_close(); ?>
                                <div class="custom-divider"><span>Or</span></div>
                                <div class="form-note-s2 text-center"> Already have an account? <a href="<?php echo USER_LOGIN_LINK; ?>" class="text-primary"><strong>Sign in</strong></a>
                                </div>
                                <div class="custom-divider"><span>Or</span></div>
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
    <script src="<?php echo ASSETS_DIR_LINK; ?>template/assets/js/scripts.js"></script>
    <script>
        $("#submit_modal").on('click', function() {
            var referral_code = $('#referral_code').val();
            if (referral_code == '') {
                alert('Please enter your referral code.');
                return false;
            } else {
                $('#referral_code').val(referral_code);
                $('#signup').submit();
            }
        });
    </script>
    <?php include(APPPATH . "Views/notify.php"); ?>
</body>

</html>