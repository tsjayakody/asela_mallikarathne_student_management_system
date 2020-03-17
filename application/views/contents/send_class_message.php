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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary">
                        <div class="col-sm-12">
                            <h4 class="card-title" style="color: white; font-weight: 700;" id="creditlbl"></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="selectpicker" data-live-search="true" id="select_year" data-size="7"
                                        data-width="100%" data-style="btn btn-primary btn-round" title="Select year">
                                        <option disabled selected>Select year</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <select class="selectpicker" data-live-search="true" id="select_class" data-size="7"
                                        data-width="100%" data-style="btn btn-primary btn-round" title="Select class">
                                        <option disabled selected>Select class</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <textarea onfocus="textCounter(this,'remaintext',160);" onkeydown="textCounter(this,'remaintext',160);" onkeyup="textCounter(this,'remaintext',160);" name="textmsg" id="textmsg"></textarea>
                        </div>
                        <div class="col-sm-12"><span id="remaintext"></span> characters left.</div>
                        <div class="col-sm-12">
                            <button class="btn btn-primary btn-block" id="sendsms">Send SMS</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>