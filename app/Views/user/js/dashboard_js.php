<div class="modal" id="accountDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Account Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12 d-flex align-items-center">
                        <label class="w-100 fw-bold me-2 mb-0">Account Number:</label>
                        <p id="acc_no" class="form-control-plaintext"></p>
                    </div>

                    <div class="col-md-12 d-flex align-items-center">
                        <label class="w-100 fw-bold me-2 mb-0">Bank Name:</label>
                        <p id="bank_name" class="form-control-plaintext"></p>
                    </div>

                    <div class="col-md-12 d-flex align-items-center">
                        <label class="w-100 fw-bold me-2 mb-0">Bank Holder Name:</label>
                        <p id="bank_holder_name" class="form-control-plaintext"></p>
                    </div>

                    <div class="col-md-12 d-flex align-items-center">
                        <label class="w-100 fw-bold me-2 mb-0">IFSC Code:</label>
                        <p id="ifsc_code" class="form-control-plaintext"></p>
                    </div>

                    <div class="col-md-12 d-flex align-items-center">
                        <label class="w-100 fw-bold me-2 mb-0">UPI ID:</label>
                        <p id="upi_id" class="form-control-plaintext"></p>
                    </div>

                    <div class="col-md-12 d-flex align-items-center">
                        <label class="w-100 fw-bold me-2 mb-0">Paypal ID:</label>
                        <p id="p_pay" class="form-control-plaintext"></p>
                    </div>

                    <div class="col-md-12 d-flex align-items-center">
                        <label class="w-100 fw-bold me-2 mb-0">Google Pay ID:</label>
                        <p id="g_pay" class="form-control-plaintext"></p>
                    </div>

                    <div class="col-md-12 d-flex align-items-center">
                        <label class="w-100 fw-bold me-2 mb-0">Paytm Pay ID:</label>
                        <p id="paytm_pay" class="form-control-plaintext"></p>
                    </div>

                    <input type="hidden" id="user_id">
                    <input type="hidden" id="balance">

                    <div class="col-12">
                        <label class="fw-bold me-2 mb-0">Upload Screenshot After Payment:</label>
                        <input type="file" class="form-control" id="screenshot_input" name="screenshot" required>
                        <small id="screenshot_name" class="text-muted d-block mt-2"></small>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-secondary button-close" data-bs-dismiss="modal">Close</button>
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