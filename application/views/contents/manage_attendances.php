<style><?php require_once('assets/css/manage_attendances.css'); ?></style>
<div class="content">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="col-md-12" id="attCount"></div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <form action="" id="markAttendance">
                                    <label for="inputStudentID">Student ID</label>
                                    <input type="text" name="inputStudentID" id="inputStudentID" class="form-control">
                                    <button type="submit" class="btn btn-primary btn-block">Enter</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-5 statusDiv text-center"></div>
                        <div class="col-md-3">
                            <div id="attBlock">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>