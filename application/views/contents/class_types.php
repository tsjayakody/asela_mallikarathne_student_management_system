<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <form id="classTypeForm" action="<?php echo base_url() ?>system_operations/create_class_type" method="post"
                    novalidate="novalidate">
                    <div class="card ">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">calendar_today</i>
                            </div>
                            <h4 class="card-title">Create Class Types</h4>
                        </div>
                        <div class="card-body ">
                            <div class="form-group bmd-form-group is-filled">
                                <label for="classType" class="bmd-label-floating"> Class Type</label>
                                <input type="text" class="form-control" id="classType" required="true" aria-required="true"
                                    aria-invalid="false">
                                <label id="classType-error" class="error" for="classType"></label>
                            </div>
                            <div class="form-group bmd-form-group is-filled">
                                <label for="classTypeCode" class="bmd-label-floating"> Class Type Code</label>
                                <input type="text" class="form-control" id="classTypeCode" required="true" aria-required="true"
                                    aria-invalid="false">
                                <label id="classTypeCode-error" class="error" for="classTypeCode"></label>
                            </div>
                            <div class="form-group bmd-form-group is-filled">
                                <label for="studentCharge" class="bmd-label-floating"> Student Charge</label>
                                <input type="text" class="form-control" id="studentCharge" required="true" aria-required="true"
                                    aria-invalid="false">
                                <label id="studentCharge-error" class="error" for="studentCharge"></label>
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
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">table_chart</i>
                        </div>
                        <h4 class="card-title">Class Types</h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="classTypeTable" class="table table-striped table-no-bordered table-hover"
                                cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Class Type</th>
                                        <th>Class Type Code</th>
                                        <th>Student Charge</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Class Type</th>
                                        <th>Class Type Code</th>
                                        <th>Student Charge</th>
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