<?php

require '../paths.php';
require UTILS_PATH . 'Request.php';
require UTILS_PATH . 'DatabaseConnection.php';
require UTILS_PATH . 'functions.php';

if(!isStudent())
{
    header("Location: " . ROOT_PATH . "login.php");
    exit(0);
}

if ($_POST)
{
    studentMarkMessageAsRead(Request::getInstance()->all()['msg']);
}

$messages = studentGetUnreadMessages();

include 'header.php';
include COMMON_PATH . 'mod_read_msg.php';
?>
<style> 
body {
background: #262626 !important;
}
</style>

    <div class="container">
        <div class="content">
            <div class="panel panel-primary">
                <div class="panel-heading">UNREAD MESSAGES</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" id="work_area">
                                <?php
                                include COMMON_PATH . 'mod_pro_icon.php';
                                if (count($messages) > 0) {
                                    ?>
                                    <thead>
                                    <tr>
                                        <th>Client</th>
                                        <th>Proposal</th>
                                        <th>Subject</th>
                                        <th>Time</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($messages as $message) {
                                        ?>
                                        <tr>
                                            <td><?php echo $message['client']; ?></td>
                                            <td><?php echo $message['proposal']; ?></td>
                                            <td><?php echo $message['subject']; ?></td>
                                            <td><?php echo $message['time']; ?></td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" id="read_msg"
                                                        value="<?php echo $message['message'];?>">
                                                    Read
                                                </button>
                                            </td>
                                            <td>
                                                <form method="post"
                                                      action="<?php echo getBaseUrl() . 'student/unread_messages.php'?>">
                                                    <input name="msg" type="hidden" value="<?php echo $message['id'] ?>">
                                                    <input class="btn btn-primary btn-sm" type="submit" value="Mark as read">
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                    <?php
                                } else {
                                    ?>
                                    <div style="margin: 10px;" class="alert alert-danger">
                                        <h4><b>There are no unread messages!</b></h4>
                                    </div>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include COMMON_PATH . "footer.php";?>