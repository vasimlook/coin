<script type="text/javascript">
    function CopyToClipboard(id) {
        var r = document.createRange();
        r.selectNode(document.getElementById(id));
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(r);
        document.execCommand('copy');
        window.getSelection().removeAllRanges();
        toastr.clear();
        NioApp.Toast('Copied Success', 'success', {
            position:'top-center',timeOut:5000,showDuration:300
        });
    }
    function downloadStart() {        
        toastr.clear();
        NioApp.Toast('Download started', 'success', {
            position:'top-center',timeOut:5000,showDuration:300
        });
    }    
</script>