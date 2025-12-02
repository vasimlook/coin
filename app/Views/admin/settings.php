<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <?php
                            $attributes = ['class' => '','enctype' => 'multipart/form-data'];
                            echo form_open(ADMIN_SETTINGS_LINK, $attributes);
                            ?>
                            <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token']; ?>">
                            <input type="hidden" name="customer_rate" value="1">
                            <h5>Settings</h5>
                            <hr>
                            <div class="row"> 
                                <div class="form-group col-12 pb-2">
                                    <label class="form-label m-0" for="first_level_commission">First Level Commission</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="first_level_commission" placeholder="First Level Commission" name="first_level_commission" value="<?= (isset($setting['first_level_commission']) && !empty($setting['first_level_commission'])) ? $setting['first_level_commission']  : ''?>">
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 pb-2">
                                    <label class="form-label m-0" for="second_level_commission">Second Level Commission</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="second_level_commission" placeholder="Second Level Commission" name="second_level_commission" value="<?= (isset($setting['second_level_commission']) && !empty($setting['second_level_commission'])) ? $setting['second_level_commission']  : ''?>">
                                    </div>                                
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 pb-2">
                                    <label class="form-label m-0" for="earning_pr">Earning Percentage</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="earning_pr" placeholder="Earning Percentage" name="earning_pr" value="<?= (isset($setting['earning_pr']) && !empty($setting['earning_pr'])) ? $setting['earning_pr']  : ''?>">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mt-2">
                                        <button type="submit" class="btn btn-primary btn-block w-50" name="submit">Update</button>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
