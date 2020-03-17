<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <select class="selectpicker" data-live-search="true" id="year" data-size="7" data-width="100%"
                            data-style="btn btn-primary btn-round" title="Year">
                            <option disabled selected>Year</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="selectpicker" data-live-search="true" id="class" data-size="7" data-width="100%"
                            data-style="btn btn-primary btn-round" title="Class">
                            <option disabled selected>Class</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="material-datatables">
                    <table id="student_table" class="table table-striped table-no-bordered table-hover" cellspacing="0"
                        width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Student ID</th>
                                <th>NIC Number</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Student ID</th>
                                <th>NIC Number</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>