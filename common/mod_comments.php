<div id="comments_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="project_title" class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div>
                    <label class="control-label">Write comment</label>
                    <div class="form-group">
                        <textarea class="form-control" id="comment" maxlength="255"></textarea>
                    </div>
                    <div class="form-group">
                        <button id="comment_btn" class="btn btn-primary btn-sm">Comment</button>
                    </div>
                </div>
                <input id="current_project" type="hidden">
                <div id="comments_area">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>