<!-- content @s -->
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <h5 class="nk-block-title">Update Bank Details</h5> 
                            <hr class="text-orange-tbg"> 
                            <?php
                            $attributes = ['class' => 'gy-3', 'id' => 'bankdetails', 'name' => 'bankdetails'];
                            echo form_open(UPDATE_BANK_DETAILS_LINK, $attributes);
                            ?>
                            <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token']; ?>">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="bank_name" placeholder="Enter bank name" autocomplete="off" value="<?php echo $bank_details['bank_name']; ?>">
                                            <p class="text-danger"><?php if(isset($errors['bank_name'])) { echo $errors['bank_name']; } ?></p> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="bank_holder_name" placeholder="Enter Bank Holder Name" autocomplete="off" value="<?php echo $bank_details['bank_holder_name']; ?>">
                                            <p class="text-danger"><?php if(isset($errors['bank_holder_name'])) { echo $errors['bank_holder_name']; } ?></p> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="acc_no" placeholder="Enter Account No" autocomplete="off" value="<?php echo $bank_details['acc_no']; ?>">
                                            <p class="text-danger"><?php if(isset($errors['acc_no'])) { echo $errors['acc_no']; } ?></p> 
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="ifsc_code" placeholder="Enter IFSC code" autocomplete="off" value="<?php echo $bank_details['ifsc_code']; ?>">
                                            <p class="text-danger"><?php if(isset($errors['ifsc_code'])) { echo $errors['ifsc_code']; } ?></p> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="upi_id" placeholder="Enter UPI Id" autocomplete="off" value="<?php echo $bank_details['upi_id']; ?>">
                                            <p class="text-danger"><?php if(isset($errors['upi_id'])) { echo $errors['upi_id']; } ?></p> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="p_pay" placeholder="Enter Phone Pay Number" autocomplete="off" value="<?php echo $bank_details['p_pay']; ?>">
                                            <p class="text-danger"><?php if(isset($errors['p_pay'])) { echo $errors['p_pay']; } ?></p> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="g_pay" placeholder="Enter Google Pay Number" autocomplete="off" value="<?php echo $bank_details['g_pay']; ?>">
                                            <p class="text-danger"><?php if(isset($errors['g_pay'])) { echo $errors['g_pay']; } ?></p> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="paytm_pay" placeholder="Enter Paytm Number" autocomplete="off" value="<?php echo $bank_details['paytm_pay']; ?>">
                                            <p class="text-danger"><?php if(isset($errors['paytm_pay'])) { echo $errors['paytm_pay']; } ?></p> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row g-3">
                                <div class="col-sm-12 col-md-4 offset-md-2">
                                    <div class="form-group mt-2">
                                        <button type="submit" name="submit" class="btn btn-primary btn-block bg-orange-tbg">Update</button>  
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