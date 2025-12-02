<script type="text/javascript">
$(document).ready(function() {
    window.CopyToClipboardRefLink = function (id) {
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
});
</script>