<link rel="stylesheet" href="<?php echo ASSETS_DIR_LINK; ?>common/notify/jquery-confirm.min.css">
<script src="<?php echo ASSETS_DIR_LINK; ?>common/notify/jquery-confirm.min.js"></script>
<?php if(!isset($_SESSION['message'])){$_SESSION['message']='';} ?>
<script type="text/javascript">
    $(document).ready(function () {       
    if (<?php if (isset($_SESSION['error_toast'])) { echo $_SESSION['error_toast'];}else{echo 0; } ?> === 1)
    {
        toastr.clear();
        NioApp.Toast('<?php echo $_SESSION['message']; ?>', 'error', {            
            position:'top-center',timeOut:5000,showDuration:300,
            timeOut: 5000,
            showDuration: 300                   
        });
        <?php $_SESSION['error_toast'] = 0; ?>
    }
    if (<?php if (isset($_SESSION['success_toast'])) { echo $_SESSION['success_toast'];}else{echo 0; } ?> === 1)
    {
        toastr.clear();
        NioApp.Toast('<?php echo $_SESSION['message']; ?>', 'success', {            
            position:'top-center',timeOut:5000,showDuration:300,
            timeOut: 5000,
            showDuration: 300                    
        });
        <?php $_SESSION['success_toast'] = 0; ?>
    }     
});
</script>
