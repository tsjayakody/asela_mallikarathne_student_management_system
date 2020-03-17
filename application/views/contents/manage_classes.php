<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form id="createClass" action="<?php echo base_url() ?>system_operations/create_class" method="post"
                    novalidate="novalidate">
                    <div class="card ">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">account_circle</i>
                            </div>
                            <h4 class="card-title">Create Class</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <select class="selectpicker" data-live-search="true" id="year" data-size="7"
                                        data-width="100%" data-style="btn btn-primary btn-round" title="Select Year">
                                        <option disabled selected>Year</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="selectpicker" data-live-search="true" id="classLocation"
                                        data-size="7" data-width="100%" data-style="btn btn-primary btn-round"
                                        title="Class Location">
                                        <option disabled selected>Class Location</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="selectpicker" data-live-search="true" id="classType" data-size="7"
                                        data-width="100%" data-style="btn btn-primary btn-round" title="Class Type">
                                        <option disabled selected>Class Type</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group bmd-form-group is-filled">
                                                <label for="fromNumber" class="bmd-label-floating"> Reserved ID
                                                    From</label>
                                                <input type="number" class="form-control" id="fromNumber"
                                                    required="true" aria-required="true" aria-invalid="false">
                                                <label id="fromNumber-error" class="error" for="fromNumber"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group bmd-form-group is-filled">
                                                <label for="toNumber" class="bmd-label-floating"> Reserved ID
                                                    To</label>
                                                <input type="number" class="form-control" id="toNumber" required="true"
                                                    aria-required="true" aria-invalid="false">
                                                <label id="toNumber-error" class="error" for="toNumber"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="note" class="bmd-label-floating"> Note</label>
                                        <input type="text" class="form-control" id="note" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="note-error" class="error" for="note"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right" id="formButtons">
                            <input type="reset" hidden id="resetForm" />
                            <input type="hidden" value="create" id="functionSelector" />
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">table_chart</i>
                        </div>
                        <h4 class="card-title">Classes</h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="classTable" class="table table-striped table-no-bordered table-hover"
                                cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Year</th>
                                        <th>Class Location</th>
                                        <th>Class Type</th>
                                        <th>Note</th>
                                        <th>ID Range</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Year</th>
                                        <th>Class Location</th>
                                        <th>Class Type</th>
                                        <th>Note</th>
                                        <th>ID Range</th>
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