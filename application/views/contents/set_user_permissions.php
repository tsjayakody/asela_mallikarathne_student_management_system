<div class="content">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <select class="selectpicker" data-live-search="true" id="userSelect" data-size="7" data-width="100%"
                    data-style="btn btn-primary btn-round" title="Select System User">
                    <option disabled selected>Select System User</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">account_circle</i>
                        </div>
                        <h4 class="card-title">Views</h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="menu_table" class="table table-striped table-no-bordered table-hover"
                                cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>View Name</th>
                                        <th>Allow/Deny</th>
                                        <th>Permissions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>View Name</th>
                                        <th>Allow/Deny</th>
                                        <th>Permissions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">account_circle</i>
                        </div>
                        <h4 class="card-title">Related Permissions</h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="permission_table" class="table table-striped table-no-bordered table-hover"
                                cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>View Name</th>
                                        <th>Allow/Deny</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>View Name</th>
                                        <th>Allow/Deny</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>