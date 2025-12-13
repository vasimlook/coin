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
                                        <h4 class="nk-block-title">Register</h4>
                                        <hr>
                                    </div>
                                </div>
                                <?php
                                $attributes = ['id' => 'signup', 'name' => 'signup'];
                                echo form_open(USER_SIGNUP_LINK . $referral_code, $attributes);
                                ?>
                                <div class="form-group mb-2">
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control form-control-lg" name="name" id="name" placeholder="Enter your name" required="" autocomplete="off">
                                        <p class="text-danger"><?php if (isset($errors['name'])) {
                                                                    echo $errors['name'];
                                                                } ?></p>
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control form-control-lg" maxlength="10" minlength="10" name="username" placeholder="Enter your mobile no" required="" autocomplete="off">
                                        <p class="text-danger"><?php if (isset($errors['username'])) {
                                                                    echo $errors['username'];
                                                                } ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
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
                                    <div class="form-group pt-2">
                                        <button class="btn btn-lg btn-primary btn-block" id="btnSubmit">Register</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                    <div class="custom-divider"><span>Or</span></div>
                                    <div class="form-note-s2 text-center"> Already have an account? <a href="<?php echo USER_LOGIN_LINK; ?>" class="text-primary"><strong>Sign in</strong></a>
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