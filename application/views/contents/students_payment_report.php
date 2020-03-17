<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <select class="selectpicker" data-live-search="true" id="select_year" data-size="7"
                                data-width="100%" data-style="btn btn-primary btn-round" title="Select year">
                                <option disabled selected>Select year</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="selectpicker" data-live-search="true" id="select_class" data-size="7"
                                data-width="100%" data-style="btn btn-primary btn-round" title="Select class">
                                <option disabled selected>Select class</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group is-filled">
                                <label for="inputMonth" class="bmd-label-floating"> Month</label>
                                <input type="text" class="form-control datepicker" value="" id="inputMonth">
                                <label id="inputMonth-error" class="error" for="inputMonth"></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary btn-block" id="btnSearch">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="material-datatables">
                    <table id="pymttable" class="table table-striped table-no-bordered table-hover" cellspacing="0"
                        width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Student ID</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Student Name</th>
                                <th>Student ID</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>