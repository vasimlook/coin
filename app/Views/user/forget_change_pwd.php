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
    <link id="skin-default" rel="stylesheet" href="<?php echo ASSETS_DIR_LINK; ?>template/assets/css/login-signup.css">
    <link rel="stylesheet" href="<?php echo ASSETS_DIR_LINK; ?>template/assets/css/coin.css">
</head>

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body wide-xs pt-0">
                        <div class="brand-logo text-center">
                            <div class="coin-wrap">
                                <div class="coin"></div>
                            </div>
                        </div>
                        <div class="card card-bordered rounded-5">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Reset password</h4>
                                        <hr>
                                        <div class="nk-block-des text-white">
                                            <p>OTP Verification is completed. Now reset your password.</p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $attributes = ['id' => 'reset_password', 'name' => 'reset_password'];
                                echo form_open(USER_CHANGE_FRGT_PWD_LINK . $mono, $attributes);
                                ?>
                                <div class="form-group mb-2">
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control form-control-lg" name="new_password" placeholder="Enter new password" autocomplete="off" required="">
                                        <p class="text-danger"><?php if (isset($errors['new_password'])) {
                                                                    echo $errors['new_password'];
                                                                } ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control form-control-lg" name="confirm_new_password" placeholder="Enter confirm password" autocomplete="off" required="">
                                        <p class="text-danger"><?php if (isset($errors['confirm_new_password'])) {
                                                                    echo $errors['confirm_new_password'];
                                                                } ?></p>
                                    </div>
                                </div>
                                <div class="form-group pt-2">
                                    <button class="btn btn-lg btn-primary btn-block" id="btnSubmit">Reset</button>
                                </div>
                                <?php echo form_close(); ?>
                                <div class="custom-divider"><span>Or</span></div>
                                <div class="form-note-s2 text-center">
                                    <a class="text-light" href="<?php echo USER_LOGIN_LINK; ?>"><strong>Return to login</strong></a>
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