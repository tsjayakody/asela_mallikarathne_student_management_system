<style>
    #textmsg{
        width: 100%;
        min-height: 250px !important;
        margin-top: 15px;
        border-radius: 10px;
        font-size: 1.8em;
        padding: 10px;
    }
</style>
<div class="content">
    <div class="conteiner-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- create new collection form -->
                        <div class="col-md-6">
                            <form id="createCollectionForm">
                                <div class="row">
                                    <div class="col">
                                        <input name="collectionName" id="collectionName" type="text" class="form-control mt-2" placeholder="Collection name">
                                        <label for="collectionName" class="text-danger" id="errCollectionName"></label>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">Create collection</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- collection list table -->
                        <div class="col-md-12 mt-3">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped" id="collectionTable">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>Name of the collection</td>
                                            <td>Quantity of numbers</td>
                                            <td>Actions</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editCollectionModal" tabindex="-1" role="dialog" aria-labelledby="editCollectionModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCollectionModalTitle">Add or Remove numbers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- create add new number form -->
                <div class="col-md-12">
                    <form id="addNewNumberForm">
                        <div class="row">
                            <div class="col">
                                <input name="newNumber" id="newNumber" type="text" class="form-control mt-2" placeholder="New phone number">
                                <label for="newNumber" class="text-danger" id="errNewNumber"></label>
                                <input type="hidden" name="collectionID" id="collectionID" value="">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Add Number</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- existing numbers table -->
                <div class="col-md-12">
                    <table class="table table-sm" style="width: 100% !important;" id="existingNumbersTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Number</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="sendSmsModal" tabindex="-1" role="dialog" aria-labelledby="sendSmsModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendSmsModalTitle">Send SMS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header bg-primary">
                        <div class="col-sm-12">
                            <h4 class="card-title" style="color: white; font-weight: 700;" id="creditlbl"></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-sm-12">
                            <h4>Send SMS for: <span id="collection_name">Collection name</span></h4>
                        </div>
                        <div class="col-sm-12">
                            <textarea onfocus="textCounter(this,'remaintext',160);" onkeydown="textCounter(this,'remaintext',160);" onkeyup="textCounter(this,'remaintext',160);" name="textmsg" id="textmsg"></textarea>
                            <input type="hidden" name="collectionID" id="collectionID" value="">
                        </div>
                        <div class="col-sm-12"><span id="remaintext"></span> characters left.</div>
                        <div class="col-sm-12">
                            <button class="btn btn-primary btn-block" id="sendsms">Send SMS</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>