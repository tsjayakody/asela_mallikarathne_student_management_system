<style>
<?php require_once('./assets/css/manage_payments.css');
?>
</style>
<div class="content">
    <div class="container-fluid">
        <h4 class="title">Date of payments: <span>
                <?php
                date_default_timezone_set('Asia/Colombo');
                $date = date('d, F Y', time());
                echo $date;
            ?>
            </span></h4>
        <div class="row">
            <div class="col-md-6">
                <button id="btnEDP" class="btn btn-warning btn-block">Enter default payment</button>
            </div>

            <div class="col-md-6">
                <button id="btnECP" data-toggle="modal" data-target="#customPaymentModel"
                    class="btn btn-info btn-block">Enter custom payment</button>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="img-div">
                            <img id="imgProfile" class="profile-image"
                                src="/assets/profile_pictures/default_profile.png" alt="profile picture">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <table class="status-table">
                            <tr>
                                <td id="tblPS" colspan="2" class="theader status fail">--</td>
                            </tr>
                            <tr>
                                <td class="theader">Amount: </td>
                                <td id="tblA" class="tvalue">--</td>
                            </tr>
                            <tr>
                                <td class="theader">Name: </td>
                                <td id="tblN" class="tvalue">--</td>
                            </tr>
                            <tr>
                                <td class="theader">ID: </td>
                                <td id="tblI" class="tvalue">--</td>
                            </tr>
                            <tr>
                                <td class="theader">Class: </td>
                                <td id="tblC" class="tvalue">--</td>
                            </tr>
                            <tr>
                                <td class="theader">Last payment date: </td>
                                <td id="tblLPD" class="tvalue">--</td>
                            </tr>
                            <tr>
                                <td class="theader">Last payment amount: </td>
                                <td id="tblLPA" class="tvalue">--</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-2">
                        <button id="btnPH" data-id="" class="btn btn-danger btn-block">Payment history</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div id="customPaymentModel" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Custom payments</h4>
            </div>
            <form id="customPaymentForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="studentId">Student ID</label>
                        <input type="text" class="form-control" id="studentId" name="studentId">
                    </div>
                    <div class="form-group">
                        <label for="monthYear">Month/Year (MM/YYYY)</label>
                        <input type="text" class="form-control" id="monthYear" name="monthYear">
                    </div>
                    <div class="form-group">
                        <label for="classFee">Payment</label>
                        <input type="text" class="form-control" id="classFee" name="classFee">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary ml-3">Submit</button>
                    <button type="reset" id="resetBtn" class="btn btn-danger ml-3">Reset</button>
                    <button type="button" id="closeBtn" class="btn btn-default ml-3" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>



<!-- Modal -->
<div id="paymentHistoryModel" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Payment history - <span id="stidspan"></span></h4>
            </div>
            <div class="modal-body">
                <table id="payHistTbl" class="table table-striped table-no-bordered table-hover" cellspacing="0"
                    width="100%" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date / Time</th>
                            <th>Payment for</th>
                            <th>Amount</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Date / Time</th>
                            <th>Payment for</th>
                            <th>Amount</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default ml-3" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>