<script>
    load_user_transfer_point_list();
    function load_user_transfer_point_list() {
        var transfer_point = $('#table-user-transfer-point').DataTable({
            // responsive: true,
            // columnDefs: [{
            //     className: 'control',
            //     orderable: false,
            //     targets: 0
            // }], 
            "scrollX":true,     
            "dom": 'tp',
            "searching":true,
            "order": false,
            "ordering": false,
            "processing": true,
            "serverSide": true,
            "pageLength": 20,
            "paginationType": "simple",
            "ajax": {
                'data': function(d) {
                    d.csrf_test_name = $("#csrf_test_name").val(),
                    d.from_date = $("#transfer_point_from_date_user").val();
                    d.to_date = $("#transfer_point_to_date_user").val();
                    d.status = $("#transfer_point_status_user").val();
                    d.accept_by = $("#transfer_point_accept_by_admin").val();
                    d.search.value = $("#ut_search_datatable").val(); 
                },
                'type': 'POST',
                'url': "<?php echo ADMIN_COIN_AJAX_LINK; ?>",
                "dataSrc": function(json) {
                    $("#csrf_test_name").val(json.csrf);
                    $("input[name=csrf_test_name]").val(json.csrf);
                    return json.data;
                }
            },
            "columns": [
                {
                    "data": 0
                },
                {
                    "data": 1
                },
                {
                    "data": 2
                },
                {
                    "data": 3
                },
                {
                    "data": 4
                },
                {
                    "data": 5
                },
                {
                    "data": 6
                },
                {
                    "data": 7
                }
            ]
        }).columns.adjust();

        // $('#transfer_point_from_date_user,#transfer_point_to_date_user,#transfer_point_status_user,#transfer_point_accept_by_admin').on('change', function() {
        //     transfer_point.draw();
        // });
        $('#ut_Go_search').on('click', function() {
            transfer_point.draw();
        });
    }

// Handle click on "View" button
$(document).on("click", ".view-btn", function () {
    let imgSrc = $(this).siblings("img").attr("src");

    $("#imgModalSrc").attr("src", imgSrc);
    $("#imgModal").fadeIn();
});

// Close modal
$(document).on("click", ".img-modal-close", function () {
    $("#imgModal").fadeOut();
});

// Close when clicking outside image
$(document).on("click", "#imgModal", function (e) {
    if (e.target.id === "imgModal") {
        $("#imgModal").fadeOut();
    }
});
</script>