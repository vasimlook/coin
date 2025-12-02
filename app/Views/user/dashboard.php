<div class="nk-content" style="padding: 60px 4px;">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="row">
                        <div class="col-4">
                            <div class="card box">
                                <div class="nk-ecwg nk-ecwg6">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start">
                                            <div class="card-title">
                                                <b>
                                                    <h6 class="title text-dark fw-bold">Total Earning Coin:</h6><b class="text-success fw-bold align-center mb-0"> <?php echo $earning_coin; ?> </b>
                                                </b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card box">
                                <div class="nk-ecwg nk-ecwg6">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start">
                                            <div class="card-title">
                                                <b>
                                                    <h6 class="title text-dark fw-bold">Total First Level Commission:</h6><b class="text-success fw-bold align-center mb-0"> <?php echo $first_level_commission; ?> </b>
                                                </b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card box">
                                <div class="nk-ecwg nk-ecwg6">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start">
                                            <div class="card-title">
                                                <b>
                                                    <h6 class="title text-dark fw-bold">Total Second Level Commission:</h6><b class="text-success fw-bold align-center mb-0"><?php echo $second_level_commission; ?> </b>
                                                </b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-1">
                        <div class="col-4">
                            <div class="card box">
                                <div class="nk-ecwg nk-ecwg6">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start">
                                            <div class="card-title">
                                                <b>
                                                    <h6 class="title text-dark fw-bold">Total Users of Level 1:</h6><b class="text-success fw-bold align-center mb-0"><?php echo $level_1_user_count; ?> </b>
                                                </b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card box">
                                <div class="nk-ecwg nk-ecwg6">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start">
                                            <div class="card-title">
                                                <b>
                                                    <h6 class="title text-dark fw-bold">Total Users of Level 2:</h6><b class="text-success fw-bold align-center mb-0"><?php echo $level_2_user_count; ?> </b>
                                                </b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-1">
                        <?php
                        foreach ($allUser as $key => $value) {
                            if($value['id'] == $_SESSION['user']['id']){
                                continue;
                            }
                        ?>
                        <div class="col-12 col-md-4 mb-1">
                            <div class="card box">
                                <div class="nk-ecwg nk-ecwg6">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start">
                                            <div class="card-title">
                                                <b>
                                                    <h6 class="title text-dark fw-bold"><?php echo $value['name']; ?></h6>
                                                </b>
                                            </div>
                                        </div>
                                        <div class="data">
                                            <div class="row">
                                                <div class="col-5">
                                                    <b class="text-success fw-bold align-center mb-0"><?php echo $value['phone']; ?></b>
                                                    <p class="p-0 m-0 text-dark" style="font-size:12px;">Coin:<?php echo $value['balance']; ?></p>
                                                    <p class="p-0 m-0 text-dark" style="font-size:12px;">Earning Coin: <?php echo ($value['balance'] !='') ? $value['balance'] + (($value['balance']/100)*$_SESSION['earning_pr']) : 0;  ?></p>
                                                </div>
                                                <div class="col-4">
                                                    <button onclick="open_modal('<?php echo $value['acc_no'] ?>','<?php echo $value['bank_name'] ?>','<?php echo $value['bank_holder_name'] ?>','<?php echo $value['ifsc_code'] ?>','<?php echo $value['upi_id'] ?>','<?php echo $value['p_pay'] ?>','<?php echo $value['g_pay'] ?>','<?php echo $value['paytm_pay'] ?>','<?php echo $value['id'] ?>','<?php echo $value['balance'] ?>')" class="btn btn-sm btn-block bg-dark text-light mb-1">Buy &nbsp;<em class="icon ni ni-light"></em></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- content @e -->