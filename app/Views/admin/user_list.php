<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card card-preview">
                        <div class="card-inner">
                            <div class="row align-center">
                                <div class="col-6">
                                    <h4>User List</h4>
                                </div>
                                <div class="col-6">
                                    <a href="<?php echo ADMIN_USER_ADD_LINK; ?>" class="btn btn-primary float-end">Add&nbsp;<em class='icon ni ni-plus'></em></a>
                                </div>
                                <hr>
                                <div class="col-12 p-1">
                                    <input type="text" placeholder="Search..."  class="form-control" value="" id="search_datatable" autocomplete="off">
                                </div>
                                <div class="col-6 p-1">
                                    <select name="status" id="status" class="form-control">
                                        <option value="">All</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-6 p-1">
                                    <select name="is_system_user" id="is_system_user" class="form-control">
                                        <option value="">All</option>
                                        <option value="1">System User</option>
                                        <option value="0">Other user</option>
                                    </select>
                                </div>
                                <div class="col-6 p-1">
                                    <input type="text" placeholder="Date"  class="form-control date-picker" value="<?php echo date("d-m-Y"); ?>" data-date-format="dd-mm-yyyy" id="from_date" autocomplete="off">
                                </div>
                                <div class="col-6 p-1">
                                    <input type="text" placeholder="Date"  class="form-control date-picker" value="<?php echo date("d-m-Y"); ?>" data-date-format="dd-mm-yyyy" id="to_date" autocomplete="off">
                                </div>
                                <div class="col-6 p-1">
                                    <button class="form-control btn btn-sm btn-block bg-primary text-light" id="Go_search"> <?php echo convertToHindi('Go'); ?></button>
                                </div>
                            </div>
                            <hr>
                            <table id="table" class="table table-striped nowrap" data-auto-responsive="true" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Password</th>
                                        <th>OTP</th>
                                        <th>Registration Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div><!-- .card-preview -->
                </div> <!-- nk-block -->
            </div>
        </div>
    </div>
</div>