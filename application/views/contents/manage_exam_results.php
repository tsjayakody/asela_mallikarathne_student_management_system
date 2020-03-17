<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form id="startEnterResultsForm" action="<?php echo base_url() ?>system_operations/start_enter_results"
                    method="post" novalidate="novalidate">
                    <div class="card ">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">account_circle</i>
                            </div>
                            <h4 class="card-title">Enter Results</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <select class="selectpicker" data-live-search="true" id="select_year" data-size="7"
                                        data-width="100%" data-style="btn btn-primary btn-round" title="Select year">
                                        <option disabled selected>Select year</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="selectpicker" data-live-search="true" id="select_class" data-size="7"
                                        data-width="100%" data-style="btn btn-primary btn-round" title="Select class">
                                        <option disabled selected>Select class</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="selectpicker" data-live-search="true" id="select_exam" data-size="7"
                                        data-width="100%" data-style="btn btn-primary btn-round" title="Select exam">
                                        <option disabled selected>Select exam</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Start</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right" id="formButtons">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-icon">
                                    <i class="material-icons">table_chart</i>
                                </div>
                                <h4 class="card-title">Exam Results</h4>
                            </div>
                            <!-- <div class="col-md-4">
                                <select class="selectpicker" data-live-search="true" id="select_class_search" data-size="7"
                                    data-width="100%" data-style="btn btn-primary btn-round" title="Select class">
                                    <option disabled selected>Select class</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="selectpicker" data-live-search="true" id="select_exam_search" data-size="7"
                                    data-width="100%" data-style="btn btn-primary btn-round" title="Select exam">
                                    <option disabled selected>Select exam</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="search-btn" class="btn btn-primary">Search</button>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-2">
                                <select class="selectpicker" data-live-search="true" id="select_year_search" data-size="7"
                                    data-width="100%" data-style="btn btn-primary btn-round" title="Select year">
                                    <option disabled selected>Select year</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="selectpicker" data-live-search="true" id="select_class_search" data-size="7"
                                    data-width="100%" data-style="btn btn-primary btn-round" title="Select class">
                                    <option disabled selected>Select class</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="selectpicker" data-live-search="true" id="select_exam_search" data-size="7"
                                    data-width="100%" data-style="btn btn-primary btn-round" title="Select exam">
                                    <option disabled selected>Select exam</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Start</button>
                            </div>
                        </div>

                        <div class="material-datatables">
                            <table id="results_table" class="table table-striped table-no-bordered table-hover"
                                cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Student ID</th>
                                        <th>Model Paper</th>
                                        <th>Result</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Student ID</th>
                                        <th>Model Paper</th>
                                        <th>Result</th>
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