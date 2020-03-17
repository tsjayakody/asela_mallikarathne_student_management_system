<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <form id="yearform" action="<?php echo base_url() ?>system_operations/create_year" method="post"
                    novalidate="novalidate">
                    <div class="card ">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">calendar_today</i>
                            </div>
                            <h4 class="card-title">Years Section</h4>
                        </div>
                        <div class="card-body ">
                            <div class="form-group bmd-form-group is-filled has-success">
                                <label for="year" class="bmd-label-floating"> Year</label>
                                <input type="text" class="form-control" id="year" required="true" aria-required="true"
                                    aria-invalid="false">
                                <label id="year-error" class="error" for="year"></label>
                            </div>
                        </div>
                        <div class="card-footer text-right">
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
                        <h4 class="card-title">Years</h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="year_table" class="table table-striped table-no-bordered table-hover"
                                cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Year</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Year</th>
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