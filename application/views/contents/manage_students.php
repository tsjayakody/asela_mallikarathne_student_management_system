<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-title text-danger"><strong>Important! : </strong>Please note that, You cant change the
                    class of student after created.</div>
                <form id="createStudent" action="<?php echo base_url() ?>system_operations/create_student" method="post"
                    novalidate="novalidate">
                    <div class="card ">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">account_circle</i>
                            </div>
                            <h4 class="card-title">Create Student</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="firstName" class="bmd-label-floating"> First Name</label>
                                        <input type="text" class="form-control" id="firstName" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="firstName-error" class="error" for="firstName"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="lastName" class="bmd-label-floating"> Last Name</label>
                                        <input type="text" class="form-control" id="lastName" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="lastName-error" class="error" for="lastName"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="contactNumber" class="bmd-label-floating"> Contact Number</label>
                                        <input type="text" class="form-control" id="contactNumber" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="contactNumber-error" class="error" for="contactNumber"></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="school" class="bmd-label-floating"> School</label>
                                        <input type="text" class="form-control" id="school" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="school-error" class="error" for="school"></label>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="address" class="bmd-label-floating"> Address</label>
                                        <input type="text" class="form-control" id="address" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="address-error" class="error" for="address"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="nic" class="bmd-label-floating"> NIC Number</label>
                                        <input type="text" class="form-control" id="nic" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="nic-error" class="error" for="nic"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="manualid" class="bmd-label-floating"> Manual ID</label>
                                        <input type="number" class="form-control" id="manualid" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="manualid-error" class="error" for="manualid"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group is-filled">
                                        <label for="note" class="bmd-label-floating"> Note</label>
                                        <input type="text" class="form-control" id="note" required="true"
                                            aria-required="true" aria-invalid="false">
                                        <label id="note-error" class="error" for="note"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <select class="selectpicker" data-live-search="true" id="studentType" data-size="7"
                                        data-width="100%" data-style="btn btn-primary btn-round" title="Student Type">
                                        <option disabled selected>Student Type</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="selectpicker" data-live-search="true" id="years" data-size="7"
                                        data-width="100%" data-style="btn btn-primary btn-round" title="Class Year">
                                        <option disabled selected>Class Year</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="selectpicker" data-live-search="true" id="class" data-size="7"
                                        data-width="100%" data-style="btn btn-primary btn-round" title="Class">
                                        <option disabled selected>Class</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="selectpicker" data-live-search="true" id="paymentType" data-size="7"
                                        data-width="100%" data-style="btn btn-primary btn-round" title="Payment Type">
                                        <option disabled selected>Payment Type</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-8"></div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <h4 class="title">Profile Image</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput"
                                        id="filein">
                                        <div class="fileinput-new thumbnail">
                                            <img src="https://via.placeholder.com/600/09f/fff.png" alt="">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="profileImage" id="profileImage" />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists"
                                                data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right" id="formButtons">
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
                        <h4 class="card-title">Students
                            <button type="button" id="byid" class="btn btn-primary pull-right">Search by ID</button>
                            <button type="button" id="bycontact" class="btn btn-primary pull-right">Search by
                                contact</button>
                            <input type="text" class="form-control pull-right" placeholder="Search by name"
                                id="searchbyname" style="max-width: 250px; margin-right: 10px; margin-left: 10px">
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="student_table" class="table table-striped table-no-bordered table-hover"
                                cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>NIC Number</th>
                                        <th>Contact Number</th>
                                        <th>Address</th>
                                        <th>School</th>
                                        <th>Type</th>
                                        <th>Class</th>
                                        <th>Year</th>
                                        <th>Payment Type</th>
                                        <th>Note</th>
                                        <th>ID</th>
                                        <th>ID Number</th>

                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>NIC Number</th>
                                        <th>Contact Number</th>
                                        <th>Address</th>
                                        <th>School</th>
                                        <th>Type</th>
                                        <th>Class</th>
                                        <th>Year</th>
                                        <th>Payment Type</th>
                                        <th>Note</th>
                                        <th>ID</th>
                                        <th>ID Number</th>

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

<!-- Modal -->
<div id="viewstudentmodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">View Student</h4>
            </div>
            <div class="modal-body">
            <table class="table table-sm table-striped">
                <tr>
                    <td>Profile image</td>
                    <td id="stprof"></td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td id="stname"></td>
                </tr>
                <tr>
                    <td>Student ID</td>
                    <td id="stcid"></td>
                </tr>
                <tr>
                    <td>NIC Number</td>
                    <td id="stnic"></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td id="staddress"></td>
                </tr>
                <tr>
                    <td>Contact</td>
                    <td id="stcontact"></td>
                </tr>
                <tr>
                    <td>Is ID issued</td>
                    <td id="stidissue"></td>
                </tr>
                <tr>
                    <td>Class Location</td>
                    <td id="stcloc"></td>
                </tr>
                <tr>
                    <td>Class Type</td>
                    <td id="stctype"></td>
                </tr>
                <tr>
                    <td>Payment Type</td>
                    <td id="stptype"></td>
                </tr>
            </table>
            </div>
        </div>
    </div>
</div>