<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <h4>Edit User</h4>
                            <?php
                            $attributes = ['class' => 'gy-3', 'id' => 'admin_form', 'name' => 'add_admin', 'enctype' => 'multipart/form-data'];
                            echo form_open(ADMIN_USER_EDIT_LINK.'/'.$user_data['id'], $attributes);
                            ?>
                            <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token']; ?>">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control mobileno" name="phone" minlength="10" maxlength="10" placeholder="Enter Mobile Number" autocomplete="off" value="<?php echo $user_data['phone']; ?>" required="">
                                            <p class="text-danger"><?php if (isset($errors['phone'])) {
                                                                        echo $errors['phone'];
                                                                    } ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="name" placeholder="Enter name" value="<?php echo $user_data['name']; ?>" autocomplete="off" required="">
                                            <p class="text-danger"><?php if (isset($errors['name'])) {
                                                                        echo $errors['name'];
                                                                    } ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control" name="password" placeholder="Enter password" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="checkbox" class="form-check-input" name="is_system_user" <?php echo ($user_data['is_system_user'] == 1) ? 'checked' : ''; ?> value="1" > Is System User?
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12 col-md-4 offset-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block" name="submit">Submit</button>
                                    </div>
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