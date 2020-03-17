<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">table_chart</i>
                        </div>
                        <h4 class="card-title">Exam Schedules</h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="examstable" class="table table-striped table-no-bordered table-hover"
                                cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Class</th>
                                        <th>Paper</th>
                                        <th>Exam Type</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Notes</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Class</th>
                                        <th>Paper</th>
                                        <th>Exam Type</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Notes</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <form id="createExam" action="<?php echo base_url() ?>system_operations/create_exam" method="post"
                    novalidate="novalidate">
                    <div class="card ">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">account_circle</i>
                            </div>
                            <h4 class="card-title">Create Exam</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row mb-5">
                                <div class="col-md-2">
                                    <select class="selectpicker" data-live-search="true" id="yearSelect" data-size="7" data-width="100%"
                                        data-style="btn btn-primary btn-round" title="Select Year">
                                        <option disabled selected>Select Year</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="selectpicker" data-live-search="true" id="classSelect" data-size="7" data-width="100%"
                                        data-style="btn btn-primary btn-round" title="Select Class">
                                        <option disabled selected>Select Class</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="selectpicker" data-live-search="true" id="paperSelect" data-size="7" data-width="100%"
                                        data-style="btn btn-primary btn-round" title="Select Paper">
                                        <option disabled selected>Select Paper</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="selectpicker" id="examTypeSelect" data-live-search="true" data-size="7" data-width="100%"
                                        data-style="btn btn-primary btn-round" title="Select Exam Type">
                                        <option disabled selected>Select Exam Type</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group is-filled">
                                        <label for="datepicker" class="bmd-label-floating"> Select Date</label>
                                        <input type="text" class="form-control datepicker" value="" id="datepicker">
                                        <label id="datepicker-error" class="error" for="datepicker"></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group is-filled">
                                        <label for="timepicker" class="bmd-label-floating"> Select Time</label>
                                        <input type="text" class="form-control timepicker" value="" id="timepicker">
                                        <label id="timepicker-error" class="error" for="timepicker"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="note" class="bmd-label-floating"> Your Note</label>
                                        <input type="text" class="form-control" id="note" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="note-error" class="error" for="note"></label>
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
        </div>
    </div>
</div>