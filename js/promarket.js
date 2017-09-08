jQuery(document).ready(function () {
    $('[id^=view_icon]').click(function (e) {
        loadIcon($(this).val());
    });

    $('#print_report').click(function (e) {
        var workArea = $('#work_area');
        var printArea =  $('#print_area');
        workArea.css('display', 'none');
        printArea.css('display', '');
        printArea.printThis({loadCSS: 'promarket/css/print.css'});
        var delay = 335;//the delay caused by printThis + 2ms
        setTimeout(function() {
            printArea.css('display', 'none');
            workArea.css('display', '');
        }, delay);
    });

    $('[id^=_action_btn]').click(function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var actionConfirm = $('#action_confirm');
        actionConfirm.find('.modal-body').text($('#action_warning').val());
        var actionOk = $('#action_ok');
        actionOk.text($('#_action').val());
        actionOk.attr('href', href);
        actionConfirm.modal({show: true});
    });

    $('[id^=like_btn]').click(function (e) {
        e.preventDefault();
        var button = $(this);
        var project = button.val();
        var action = button.html().trim();
        if (action === "Like")
        {
            $.get($('#base_url').val() + "common/like_project.php" , {project: project}, function (response) {
                if ($.parseJSON(response)['success'])
                {
                    button.html("Unlike");
                    //update like count
                    var lcId = '#lc_' + project;
                    var likeCount = $(lcId);
                    likeCount.html(parseInt( likeCount.html()) + 1);
                }
            });
        }
        else if(action === "Unlike")
        {
            $.get($('#base_url').val() + "common/unlike_project.php", {project: project}, function (response) {
                if ($.parseJSON(response)['success'])
                {
                    button.html("Like");
                    var lcId = '#lc_' + project;
                    var likeCount = $(lcId);
                    likeCount.html(parseInt( likeCount.html()) - 1);
                }
            });
        }

    });

    $('[id^=view_comment_btn]').click(function (e) {
        var commentModal = $('#comments_modal');
        var button = $(this);
        var project = button.val();
        $.get($('#base_url').val() + "common/comment.php", {project: project, load: true}, function (response) {
            response = $.parseJSON(response);
            commentModal.find('#current_project').val(project);
            commentModal.find('#project_title').html("Comments : " + response.title);
            commentModal.find('#comments_area').html(response.comments);
            commentModal.modal({show: true});
        });
    });

    $('[id^=comment_btn]').click(function (e) {
        var project = $('#current_project').val();
        var commentArea = $('#comment');
        var comment = commentArea.val();
        if (comment === '')
        {
            return;
        }
        commentArea.val('');
        var commentModal = $('#comments_modal');
        commentModal.modal({show: false});
        $.get($('#base_url').val() + "common/comment.php", {project: project, comment: comment}, function (response) {
            response = $.parseJSON(response);
            commentModal.find('#current_project').val(project);
            commentModal.find('#project_title').html("Comments : " + response.title);
            commentModal.find('#comments_area').html(response.comments);
            //update comment count
            var ccId = '#cc_' + project;
            var commentCount = $(ccId);
            commentCount.html(parseInt( commentCount.html()) + 1);
            commentModal.modal({show: true});
        });
    });

    $('[id^=_contact_btn]').click(function (e) {
        e.preventDefault();
        var contactModal = $('#contact_modal');
        contactModal.find('#project').val($(this).val());
        contactModal.modal({show: true});
    });

    $('[id^=read_msg]').click(function (e) {
        e.preventDefault();
        var readMessageModal = $('#msg_modal');
        readMessageModal.find('#msg_area').html($(this).val());
        readMessageModal.modal({show: true});
    });

    $('[id^=view_description]').click(function (e) {
        e.preventDefault();
        var viewDescriptionModal = $('#desc_modal');
        viewDescriptionModal.find('#desc_area').html($(this).val());
        viewDescriptionModal.modal({show: true});
    });
});

function loadIcon(name){
    $.get($('#base_url').val() + "common/load_icon.php" , {name: name}, function (response) {
        var iconArea = $('#icon_area');
        iconArea.html(response);
        $('#icon_modal').modal({show: true});
    });
}