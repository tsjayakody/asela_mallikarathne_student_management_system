<style>
<?php require_once('./assets/css/manage_payments.css');
?>
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Issue ID Cards</div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <button class="btn btn-primary btn-block btn-lg" data-toggle="modal"
                            data-target="#issueid_model" id="issueid">Issue ID Cards</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Print Bulk ID</div>
                    </div>
                    <form id="bulk_print_form">
                        <div class="card-body">
                            <div class="col-md-12">
                                <select class="selectpicker" data-live-search="true" name="selectYear" id="selectYear" data-size="7"
                                    data-width="100%" data-style="btn btn-primary btn-round" title="Select year">
                                    <option disabled selected>Select year</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <select class="selectpicker" data-live-search="true" id="selectClass" name="selectClass"
                                    data-size="7" data-width="100%" data-style="btn btn-primary btn-round"
                                    title="Select Class">
                                    <option disabled selected>Select Class</option>
                                </select>
                            </div>
                            <div class="col-md-12 checkbox-radios">
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="is_issued" value="0"
                                                    checked> Students ID Not Issued
                                                <span class="circle">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="is_issued" value="1">
                                                Students ID Already Issued
                                                <span class="circle">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <button type="submit" class="btn btn-success btn-block btn-lg" id="print_bulk">Print Bulk
                                ID</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Print single ID</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="student_id">Student ID</label>
                            <input type="text" class="form-control" name="student_id" id="student_id">
                        </div>
                        <button class="btn btn-danger btn-block btn-lg" id="print_single">Generate</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="issueid_model" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Issue ID Cards</h4>
            </div>
            <form id="form_issueid">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="studentId">Student ID</label>
                        <input type="text" class="form-control" id="studentId" name="studentId">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary ml-3">Submit</button>
                    <button type="button" id="closeBtn" class="btn btn-default ml-3" data-dismiss="modal">Close</button>
                </div>
            </form>
            <div class="model-body">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="img-div">
                                        <img id="imgProfile" class="profile-image"
                                            src="/assets/profile_pictures/default_profile.png" alt="profile picture">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <table class="status-table">
                                        <tr>
                                            <td id="tbl_sts" colspan="2" class="theader status fail">--</td>
                                        </tr>
                                        <tr>
                                            <td class="theader">Student ID: </td>
                                            <td id="tbl_stid" class="tvalue">--</td>
                                        </tr>
                                        <tr>
                                            <td class="theader">Name: </td>
                                            <td id="tbl_stname" class="tvalue">--</td>
                                        </tr>
                                        <tr>
                                            <td class="theader">Class: </td>
                                            <td id="tbl_class" class="tvalue">--</td>
                                        </tr>
                                        <tr>
                                            <td class="theader">Student Type: </td>
                                            <td id="tbl_sttype" class="tvalue">--</td>
                                        </tr>
                                        <tr>
                                            <td class="theader">Payment Type: </td>
                                            <td id="tbl_stpaytype" class="tvalue">--</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>