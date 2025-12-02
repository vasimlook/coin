<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <h4>Change Password</h4>
                            <hr>
                            <?php
                            $attributes = ['class' => 'gy-3', 'id' => 'change_pwd_form', 'name' => 'change_pwd'];
                            echo form_open(ADMIN_CHANGE_PWD_LINK, $attributes);
                            ?>
                            <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token']; ?>">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control" name="old_password" placeholder="Enter old password" autocomplete="off" required="">
                                            <p class="text-danger"><?php if (isset($errors['old_password'])) {
                                                                        echo $errors['old_password'];
                                                                    } ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control" name="new_password" placeholder="Enter new password" autocomplete="off" required="">
                                            <p class="text-danger"><?php if (isset($errors['new_password'])) {
                                                                        echo $errors['new_password'];
                                                                    } ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control" name="confirm_new_password" placeholder="Enter confirm new password" autocomplete="off" required="">
                                            <p class="text-danger"><?php if (isset($errors['confirm_new_password'])) {
                                                                        echo $errors['confirm_new_password'];
                                                                    } ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="form-group text-center col-sm-12 col-md-4">
                                    <button type="submit" class="btn btn-primary btn-block" name="submit">Submit</button>
                                </div>                                
                            </div>                            
                            <?php echo form_close(); ?>
                        </div>
                    </div><!-- card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>