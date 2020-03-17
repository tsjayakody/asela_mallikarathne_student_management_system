<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <form id="createClassLocation" action="<?php echo base_url() ?>system_operations/create_class_location">
                    <div class="card ">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">account_circle</i>
                            </div>
                            <h4 class="card-title">Create Class Locations</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="location" class="bmd-label-floating"> Location Name</label>
                                        <input type="text" class="form-control" id="location" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="location-error" class="error" for="location"></label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="locationCode" class="bmd-label-floating"> Location Code</label>
                                        <input type="text" class="form-control" id="locationCode" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="locationCode-error" class="error" for="locationCode"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right" id="formButtons">
                            <input type="reset" hidden id="resetForm" />
                            <input type="hidden" value="create" id="functionSelector"/>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">table_chart</i>
                        </div>
                        <h4 class="card-title">Class Locations</h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="classLocationTable" class="table table-striped table-no-bordered table-hover"
                                cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Location</th>
                                        <th>Location Code</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Location</th>
                                        <th>Location Code</th>
                                        <th class="text-right">Actions</th>
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