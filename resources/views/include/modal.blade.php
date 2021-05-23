<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
            </div>
            <div class="modal-body">
                <form action="post" id="form_submit" enctype="multipart/form" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3">Email : </label>
                        <div class="col-md-9">
                            <input type="email" name="email" id="email" class="form-control" />
                            <span id="email_error" style="color: red"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Full Name :</label>
                        <div class="col-md-9">
                            <input type="text" name="name" id="name" class="form-control" />
                            <span id="name_error" style="color: red"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Date of Joining : </label>
                        <div class="col-md-9">
                            <input type="date" name="doj" id="doj" class="form-control" />
                            <span id="doj_error" style="color: red"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Date of Leaving : </label>
                        <div class="col-md-6">
                            <input type="date" name="dol" id="dol" class="form-control" />
                            <span id="dol_error" style="color: red"></span>
                        </div>
                        <div class="col-md-3">
                            <input class="form-check-input" type="checkbox" name="still_working" value="1" id="still_working">
                            <label class="form-check-label" for="still_working">
                                Still Working
                            </label>
                            <span id="still_working_error" style="color: red"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Select Avatar: </label>
                        <div class="col-md-9">
                            <input type="file" class="form-control" name="image" id="image" />
                            <span id="image_error" style="color: red"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="hidden" name="action" id="action" />
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="submit" name="action_button" id="action_button"
                                class="btn btn-primary pull-right" value="Submit" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
