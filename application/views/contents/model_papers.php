<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <form id="modelPaperForm" action="<?php echo base_url() ?>system_operations/create_model_paper" method="post"
                    novalidate="novalidate">
                    <div class="card ">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">calendar_today</i>
                            </div>
                            <h4 class="card-title">Create Model Papers</h4>
                        </div>
                        <div class="card-body ">
                            <div class="form-group bmd-form-group is-filled">
                                <label for="paperType" class="bmd-label-floating"> Paper Type</label>
                                <input type="text" class="form-control" id="paperType" required="true" aria-required="true"
                                    aria-invalid="false">
                                <label id="paperType-error" class="error" for="paperType"></label>
                            </div>
                            <div class="form-group bmd-form-group is-filled">
                                <label for="paperTypeCode" class="bmd-label-floating"> Paper Type Code</label>
                                <input type="text" class="form-control" id="paperTypeCode" required="true" aria-required="true"
                                    aria-invalid="false">
                                <label id="paperTypeCode-error" class="error" for="paperTypeCode"></label>
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
                        <h4 class="card-title">Model Papers</h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="modelPaperTable" class="table table-striped table-no-bordered table-hover"
                                cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Paper Type</th>
                                        <th>Paper Type Code</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Paper Type</th>
                                        <th>Paper Type Code</th>
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