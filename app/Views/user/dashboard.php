<div class="nk-content pt-1">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="container pt-4">
                        <div class="gamble-board">
                            <!-- TOTAL -->
                            <div class="total-box p-4 mb-3">
                                <small class="text-uppercase text-light opacity-75">Total Earning</small>
                                <h1 class="fw-bold text-gold pulse"><?php echo ($earning_coin != '') ? $earning_coin : 0; ?></h1>
                            </div>
                            <!-- GRID -->
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="stat-box">
                                        <span>Level 1 Earning</span>
                                        <h2 class="text-neon"><?php echo ($first_level_commission != '') ? $first_level_commission : 0; ?></h2>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-box">
                                        <span>Level 2 Earning</span>
                                        <h2 class="text-neon"><?php echo ($second_level_commission != '') ? $second_level_commission : 0; ?></h2>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-box members">
                                        <span>Level 1 Members</span>
                                        <h2><?php echo ($level_1_user_count != '') ? $level_1_user_count : 0; ?></h2>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-box members">
                                        <span>Level 2 Members</span>
                                        <h2><?php echo ($level_2_user_count != '') ? $level_2_user_count : 0; ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-transparent">
                        <div class="card-inner pt-0">
                            <div class="row">
                                <?php
                                foreach ($allUser as $key => $value) {
                                    if ($value['id'] == $_SESSION['user']['id'] && $value['balance'] > 0) {
                                        continue;
                                    }
                                ?>
                                    <div class="container pt-2">
                                        <div class="bet-card p-4">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h4 class="fw-bold text-neon"><?php echo $value['name']; ?></h4>
                                                    <p class="mb-1 text-info">📞 <?php echo $value['phone']; ?></p>
                                                </div>

                                                <button class="btn bet-btn" onclick="open_modal('<?php echo $value['acc_no'] ?>','<?php echo $value['bank_name'] ?>','<?php echo $value['bank_holder_name'] ?>','<?php echo $value['ifsc_code'] ?>','<?php echo $value['upi_id'] ?>','<?php echo $value['p_pay'] ?>','<?php echo $value['g_pay'] ?>','<?php echo $value['paytm_pay'] ?>','<?php echo $value['id'] ?>','<?php echo $value['balance'] ?>')">
                                                    🎲 BUY
                                                </button>
                                            </div>

                                            <hr class="bet-divider">

                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <p class="mb-1 text-muted">Pay</p>
                                                    <h3 class="fw-bold text-warning"><?php echo $value['balance']; ?></h3>
                                                </div>
                                                <div class="col-6">
                                                    <p class="mb-1 text-muted">Coin Get</p>
                                                    <h3 class="fw-bold text-success"><?php echo ($value['balance'] != '') ? $value['balance'] + (($value['balance'] / 100) * $_SESSION['earning_pr']) : 0;  ?></h3>
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