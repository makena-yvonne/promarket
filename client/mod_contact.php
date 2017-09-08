<div id="contact_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content col-lg-11">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="text-align: center"><b>Contact</b></h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo getBaseUrl() . 'client/timeline.php'?>" class="form-horizontal">
                    <input hidden id="project" name="project">
                    <div class="form-group">
                        <label for="inputSubject" class="col-sm-2 control-label">Subject</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control"  name="subject"
                                   placeholder="subject" required>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="inputSubject" class="col-sm-2 control-label">Message</label>

                        <div class="col-sm-10">
                            <textarea class="form-control" name="message" style="min-height: 100px" required>
                            </textarea>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 pull-right">
                            <input type="submit" class="btn btn-primary pull-right" value="Send">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>