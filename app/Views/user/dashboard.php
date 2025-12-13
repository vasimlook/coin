<div class="nk-content pt-1">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card bg-transparent">
                        <div class="card-inner p-1">
                            <div class="row">
                                <div class="col-12 col-md-3 p-1">
                                    <div class="card bg-primary is-dark">
                                        <div class="card-inner">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="fs-6 text-white text-opacity-75 mb-0">Total Earning</div>
                                            </div>
                                            <h5 class="fs-1 text-white"><?php echo ($earning_coin != '') ? $earning_coin : 0; ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 p-1">
                                    <div class="card bg-primary is-dark">
                                        <div class="card-inner">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="fs-6 text-white text-opacity-75 mb-0">Level 1 Earning</div>
                                            </div>
                                            <h5 class="fs-1 text-white"><?php echo ($first_level_commission != '') ? $first_level_commission : 0; ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 p-1">
                                    <div class="card bg-primary is-dark">
                                        <div class="card-inner">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="fs-6 text-white text-opacity-75 mb-0">Level 2 Earning</div>
                                            </div>
                                            <h5 class="fs-1 text-white"><?php echo $second_level_commission; ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 p-1">
                                    <div class="card bg-primary is-dark">
                                        <div class="card-inner">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="fs-6 text-white text-opacity-75 mb-0">Level 1 Members</div>
                                            </div>
                                            <h5 class="fs-1 text-white"><?php echo $level_1_user_count; ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3  p-1">
                                    <div class="card bg-primary is-dark">
                                        <div class="card-inner">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="fs-6 text-white text-opacity-75 mb-0">Level 2 Members</div>
                                            </div>
                                            <h5 class="fs-1 text-white"><?php echo $level_2_user_count; ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- card -->
                    <div class="card bg-transparent">
                        <div class="card-inner">
                            <div class="row">
                                <?php
                                foreach ($allUser as $key => $value) {
                                    if ($value['id'] == $_SESSION['user']['id']) {
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
                                                                <p class="p-0 m-0 text-dark" style="font-size:12px;">Earning Coin: <?php echo ($value['balance'] != '') ? $value['balance'] + (($value['balance'] / 100) * $_SESSION['earning_pr']) : 0;  ?></p>
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
                    </div><!-- card -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content @e -->