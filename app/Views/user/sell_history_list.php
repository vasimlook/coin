<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <div class="row align-center">
                                <div class="col-12">
                                    <h4 class="d-flex">Sell History</h4>
                                </div>
                                <hr>
                                <div class="col-4 col-md-2 p-1">
                                    <input type="text" placeholder="Date"  class="form-control date-picker" value="<?php echo date('d-m-Y'); ?>" value="" data-date-format="dd-mm-yyyy" id="transfer_point_from_date_user" autocomplete="off">
                                </div>
                                <div class="col-4 col-md-2 p-1">
                                    <input type="text" placeholder="Date"  class="form-control date-picker" value="<?php echo date('d-m-Y'); ?>" value="" data-date-format="dd-mm-yyyy" id="transfer_point_to_date_user" autocomplete="off">
                                </div>
                                <div class="col-4 col-md-2 p-1">
                                    <select name="transfer_point_status_user" id="transfer_point_status_user" class="form-control">
                                        <option value="">All</option>
                                        <option value="1">Pending</option>
                                        <option value="2">Accepted</option>
                                    </select>
                                </div>
                                 <div class="col-4 col-md-3 p-1">
                                    <input type="text" placeholder="Search..."  class="form-control" value="" id="ut_search_datatable" autocomplete="off">
                                </div>
                                <div class="col-4 col-md-2 p-1">
                                    <div class="form-group">
                                        <div class="form-control-wrap">  
                                            <button class="form-control btn btn-sm btn-block bg-primary text-light mb-1" id="ut_Go_search">Go</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <table id="table-user-transfer-point" class="table table-striped nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>                                        
                                        <th>Buyer Name</th>
                                        <th>Buyer Phone</th>
                                        <th>Screenshot</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Image Zoom Modal -->
<div id="imgModal" class="img-modal">
    <span class="img-modal-close">&times;</span>
    <img class="img-modal-content" id="imgModalSrc">
</div>