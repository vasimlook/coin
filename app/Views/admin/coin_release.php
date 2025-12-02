<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <h4>Release Coin</h4>
                            <?php
                            $attributes = ['class' => 'gy-3', 'id' => 'admin_form', 'name' => 'add_admin', 'enctype' => 'multipart/form-data'];
                            echo form_open(ADMIN_RELEASE_COIN_LINK, $attributes);
                            ?>
                            <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token']; ?>">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="amount" placeholder="Enter amount" autocomplete="off" required="">
                                            <p class="text-danger"><?php if (isset($errors['amount'])) { echo $errors['amount']; } ?></p>
                                        </div>                                    
                                    </div>
                                </div>
                            </div>
                            <?php 
                            if(!empty($user_data)){
                                foreach($user_data as $user){
                            ?>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="checkbox" class="form-check-input" name="user_id[]" value="<?php echo $user['id']; ?>" > <?php echo $user['name'].' ('.$user['phone'].')'; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            }
                            ?>
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