<div class="modal fade" id="accountDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm modal-md">
        <div class="modal-content bet-modal">

            <div class="modal-header border-0">
                <h5 class="modal-title text-neon">
                    🪙 Account Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="info-row">
                    <span>Account No</span>
                    <strong id="acc_no">*****45891</strong>
                </div>

                <div class="info-row">
                    <span>Bank</span>
                    <strong id="bank_name">HDFC Bank</strong>
                </div>

                <div class="info-row">
                    <span>Holder</span>
                    <strong id="bank_holder_name">Rahul Sharma</strong>
                </div>

                <div class="info-row">
                    <span>IFSC</span>
                    <strong id="ifsc_code">HDFC0001234</strong>
                </div>

                <div class="info-row">
                    <span>UPI</span>
                    <strong id="upi_id">rahul@upi</strong>
                </div>

                <div class="info-row">
                    <span>PhonePe</span>
                    <strong id="p_pay">rahul@mail.com</strong>
                </div>

                <div class="info-row">
                    <span>GPay</span>
                    <strong id="g_pay">rahul@gpay</strong>
                </div>

                <div class="info-row">
                    <span>Paytm</span>
                    <strong id="paytm_pay">rahul@paytm</strong>
                </div>

                <div class="mt-3">
                    <label class="form-label text-light small fw-bold">
                        📤 Upload Payment Screenshot
                    </label>
                    <input type="file" class="form-control bet-input" id="screenshot_input">
                    <small id="screenshot_name" class="text-muted"></small>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-bet w-100">
                    🚀 Submit Payment
                </button>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {
        $(".button-close").click(function() {
            $("#accountDetailModal").modal('hide');
        });
    });

    function open_modal(acc_no, bank_name, bank_holder_name, ifsc_code, upi_id, p_pay, g_pay, paytm_pay, user_id, balance) {
        $('#acc_no').text(acc_no);
        $('#bank_name').text(bank_name);
        $('#bank_holder_name').text(bank_holder_name);
        $('#ifsc_code').text(ifsc_code);
        $('#upi_id').text(upi_id);
        $('#p_pay').text(p_pay);
        $('#g_pay').text(g_pay);
        $('#paytm_pay').text(paytm_pay);
        $('#user_id').val(user_id);
        $('#balance').val(balance);
        $('#accountDetailModal').modal('show');
    }
    (function($) {
        var selectedFile = null;

        $('#screenshot_input').on('change', function() {
            selectedFile = this.files && this.files[0] ? this.files[0] : null;
            $('#screenshot_name').text(selectedFile ? selectedFile.name : '');
        });

        // Bind footer submit button to perform the upload when clicked
        $('.modal-footer .btn-primary').off('click.uploadScreenshot').on('click.uploadScreenshot', function(e) {
            if (!selectedFile) {
                alert('Please select a screenshot to upload.');
                return;
            }

            var fd = new FormData();
            fd.append('screenshot', selectedFile);
            fd.append('user_id', $('#user_id').val());
            fd.append('balance', $('#balance').val());
            fd.append("<?= csrf_token() ?>", "<?= csrf_hash() ?>");

            $.ajax({
                url: '<?php echo BUY_COIN; ?>',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        NioApp.Toast(response.message, 'success', {
                            position: 'top-center',
                            timeOut: 5000,
                            showDuration: 300
                        });
                        $('#accountDetailModal').modal('hide');
                    } else {
                        NioApp.Toast(response.message, 'error', {
                            position: 'top-center',
                            timeOut: 5000,
                            showDuration: 300
                        });
                    }
                },
                error: function(xhr) {
                    NioApp.Toast('Upload failed. Please try again.', 'error', {
                        position: 'top-center',
                        timeOut: 5000,
                        showDuration: 300
                    });
                }
            });
        });
    })(jQuery);
</script>