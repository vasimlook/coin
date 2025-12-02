<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful color game for make big profit">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?php echo ASSETS_DIR_LINK; ?>template/images/favicon.png">
    <!-- Page Title  -->
    <title><?php echo $title; ?></title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?php echo ASSETS_DIR_LINK; ?>template/assets/css/dashlite.css">
    <link id="skin-default" rel="stylesheet" href="<?php echo ASSETS_DIR_LINK; ?>template/assets/css/theme.css">
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
                                        <h4 class="nk-block-title">Sign-In</h4>
                                        <div class="nk-block-des">
                                            <p>Access the <?php echo APP_NAME; ?> panel using your email and passcode.</p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $attributes = ['id' => 'login', 'name' => 'login']; 
                                echo form_open(ADMIN_LOGIN_LINK,$attributes);
                                ?>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="default-01">Email or Username</label>
                                    </div>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control form-control-lg" maxlength="10" minlength="10" name="username" placeholder="Enter your mobile no" required="" autocomplete="off">
                                        <p class="text-danger"><?php if (isset($errors['username'])) {
                                                                    echo $errors['username'];
                                                                } ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="password">Passcode</label>
                                        <!-- <a class="link link-primary link-sm" href="<?php //echo USER_FORGET_PWD_LINK; ?>">Forgot Password?</a> -->
                                    </div>
                                    <div class="form-control-wrap">
                                        <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Enter your password" required="" autocomplete="off">
                                        <p class="text-danger"><?php if (isset($errors['password'])) {
                                                                    echo $errors['password'];
                                                                } ?></p>
                                    </div>
                                </div>
                                <div class="form-group pt-2">
                                    <button class="btn btn-lg btn-primary btn-block">Sign in</button>
                                </div>
                                <?php echo form_close(); ?>                                
                            </div>
                        </div>
                    </div>
                    <div class="nk-footer nk-auth-footer-full">
                        <div class="container wide-lg">
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="nk-block-content text-center text-lg-start">
                                        <p class="text-soft">&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?> . All Rights Reserved.</p>
                                    </div>
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
    <script src="<?php echo ASSETS_DIR_LINK; ?>template/assets/js/scripts.js"></script>
    <?php include(APPPATH . "Views/notify.php"); ?>
</body>

</html>