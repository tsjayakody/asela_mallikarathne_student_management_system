<div class="content">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                    data-target="#iwreport">
                                    Islandwide Report
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-success btn-block" data-toggle="modal"
                                    data-target="#clsreport">
                                    Class Report
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-warning btn-block" data-toggle="modal"
                                    data-target="#sendsmsmodal">
                                    Send Result SMS
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="material-datatables">
                        <table id="result_table" class="table table-striped table-no-bordered table-hover"
                            cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Class Name</th>
                                    <th>Student Name</th>
                                    <th>Student ID</th>
                                    <th>Result</th>
                                    <th>Class Rank</th>
                                    <th>Island Rank</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Class Name</th>
                                    <th>Student Name</th>
                                    <th>Student ID</th>
                                    <th>Result</th>
                                    <th>Class Rank</th>
                                    <th>Island Rank</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ilandwide result Modal -->
<div class="modal fade" id="iwreport" tabindex="-1" role="dialog" aria-labelledby="iwreportlbl" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iwreportlbl">Islandwide Student Results</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <select class="selectpicker" id="selectYearI" data-size="7" data-width="100%"
                        data-style="btn btn-primary btn-round" title="Select Year">
                        <option disabled selected>Select Year</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <select class="selectpicker" id="selectClassTypeI" data-size="7" data-width="100%"
                        data-style="btn btn-primary btn-round" title="Select Class Type">
                        <option disabled selected>Select Class Type</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <select class="selectpicker" id="selectModelPaperI" data-size="7" data-width="100%"
                        data-style="btn btn-primary btn-round" title="Select Model Paper">
                        <option disabled selected>Select Model Paper</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="getIslandReport">Get Results</button>
            </div>
        </div>
    </div>
</div>


<!-- class result Modal -->
<div class="modal fade" id="clsreport" tabindex="-1" role="dialog" aria-labelledby="clsreportlbl" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clsreportlbl">Class Student Results</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <select class="selectpicker" id="selectYearC" data-size="7" data-width="100%"
                        data-style="btn btn-primary btn-round" title="Select Year">
                        <option disabled selected>Select Year</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <select class="selectpicker" id="selectClassC" data-size="7" data-width="100%"
                        data-style="btn btn-primary btn-round" title="Select Class">
                        <option disabled selected>Select Class</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <select class="selectpicker" id="selectExamC" data-size="7" data-width="100%"
                        data-style="btn btn-primary btn-round" title="Select Exam">
                        <option disabled selected>Select Exam</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="getClassReportBtn" class="btn btn-primary">Get Results</button>
            </div>
        </div>
    </div>
</div>

<!-- send sms model -->
<div class="modal fade" id="sendsmsmodal" tabindex="-1" role="dialog" aria-labelledby="sendsmsmodallbl"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendsmsmodallbl"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smsmodalbody">
                <div class="col-md-12">
                    <select class="selectpicker" id="selectYearSMS" data-size="7" data-width="100%"
                        data-style="btn btn-primary btn-round" title="Select Year">
                        <option disabled selected>Select Year</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <select class="selectpicker" id="selectClassSMS" data-size="7" data-width="100%"
                        data-style="btn btn-primary btn-round" title="Select Class">
                        <option disabled selected>Select Class</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <select class="selectpicker" id="selectExamSMS" data-size="7" data-width="100%"
                        data-style="btn btn-primary btn-round" title="Select Exam">
                        <option disabled selected>Select Exam</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sendSmsBtn">Send SMS</button>
            </div>
        </div>
    </div>
</div>