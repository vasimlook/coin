<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <?php if (!empty($user_info)) { ?>
                    <div class="nk-block nk-block-lg">
                        <div class="alert alert-fill alert-icon alert-danger" role="alert">
                            <em class="icon ni ni-wallet-saving"></em>Coin
                            <strong>
                                <h5 class=""><?php echo $user_info['balance']; ?></h5>
                            </strong>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <h5 class="">User Details</h5>
                                <hr>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td><span class="">Name</span></td>
                                            <td>:</td>
                                            <td><?php echo $user_info['name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><span class="">Phone No</span></td>
                                            <td>:</td>
                                            <td>
                                                <span id="copy_link">
                                                    <?php echo $user_info['phone']; ?>
                                                </span>
                                                <button class="btn btn-xs bg-primary text-white" onclick="CopyToClipboardRefLink('copy_link');return false;"><em class="icon ni ni-copy"></em></button>
                                                <a href="https://wa.me/<?php echo $user_info['phone']; ?>"><img src="https://img.icons8.com/ios-filled/24/25D366/whatsapp.png" alt="WhatsApp" style="vertical-align: middle;"></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="">Account No</span></td>
                                            <td>:</td>
                                            <td><?php echo $user_info['acc_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><span class="">Bank Name</span></td>
                                            <td>:</td>
                                            <td><?php echo $user_info['bank_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><span class="">Bank Holder Name</span></td>
                                            <td>:</td>
                                            <td><?php echo $user_info['bank_holder_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><span class="">IFSC Code</span></td>
                                            <td>:</td>
                                            <td><?php echo $user_info['ifsc_code']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><span class="">UPI Id</span></td>
                                            <td>:</td>
                                            <td><?php echo $user_info['upi_id']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="nk-block nk-block-lg">
                        <div class="card">
                            <div class="card-inner">
                                <div class="alert alert-fill alert-icon alert-danger" role="alert">
                                    <em class="icon ni ni-alert-circle"></em>
                                    <strong>
                                        <h3 class="">No Details Found</h3>
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>