<div class="modal fade" id="agentModal" tabindex="-1" aria-labelledby="agentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agentModalLabel">Are you sure to change status ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="agentForm">
                    <input type="hidden" name="status_val" id="status_val" value="">
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <div class="form-group">
                        <label for="status" class="col-form-label">Note:</label>
                        <textarea class="form-control" id="note" name="note"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-form-label">Yantra Percentage (%):</label>
                        <input type="tel" class="form-control mobileno" id="yantra_percentage" name="yantra_percentage">
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-form-label">Mataka Percentage (%):</label>
                        <input type="tel" class="form-control mobileno" id="mataka_percentage" name="mataka_percentage">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="becom_agent_submit" onclick="update_status();" data-bs-dismiss="modal">Yes, Proceed</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        load_user_list();
        function load_user_list() {
            var dataTable = $('#table').DataTable({
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
                "ordering": true,
                "processing": true,
                "serverSide": true,
                "pageLength": 20,
                "paginationType": "simple",
                "ajax": {
                    'data': function(d) {
                        d.csrf_test_name = $("#csrf_test_name").val();
                        d.user_type = '<?php echo $user_type; ?>';
                        d.status = $("#status").val();
                        d.from_date = $("#from_date").val();
                        d.to_date = $("#to_date").val();
                        d.is_system_user = $("#is_system_user").val();
                        d.search.value = $("#search_datatable").val(); 
                    },
                    'type': 'POST',
                    'url': "<?php echo ADMIN_USER_AJAX_LIST_LINK; ?>",
                    "dataSrc": function(json) {
                        $("#csrf_test_name").val(json.csrf);
                        $("input[name=csrf_test_name]").val(json.csrf);
                        return json.data;
                    }
                },
                "columns": [{
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

            $('#Go_search').on('click', function() {
                dataTable.search(this.value).draw();
            });
        }
    });

    function update_status(id,type_value)
    {
        if(type_value == '' || type_value == undefined)
        {
            type_value = 'status';
        }
        status_val = Number($("#status_"+id).is(":checked"));
        if(status_val == 1) {
            $('input[id="status_'+id+'"]').prop('checked', true);
        } else if(status_val == 0) {
            $('input[id="status_'+id+'"]').prop('checked', false);
        }
        if(type_value == 'become_agent')
        {
            status_val = $("#status_val").val();
        }

        $.ajax({
            url: "<?php echo ADMIN_USER_UPDATE_STATUS; ?>",
            type: 'POST',
            data: {'id':id,'status':status_val,'type':type_value},
            dataType: "text",
            success: function (result) {
                if(result == 1)
                {
                    NioApp.Toast('Status changed successfully', 'success',{
                        position:'top-center',timeOut:5000,showDuration:300
                    });
                    if(type_value == 'become_agent')
                    {
                        location.reload();
                    }
                }
                else
                {
                    NioApp.Toast('something went wrong please try again', 'error',{
                        position:'top-center',timeOut:5000,showDuration:300
                    });
                }
            }
        });
    }

</script>