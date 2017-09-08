<?php

require '../paths.php';
require UTILS_PATH . 'DatabaseConnection.php';
require UTILS_PATH . 'Request.php';
require UTILS_PATH . 'functions.php';

if(!isStudent())
{
    header("Location: " . ROOT_PATH . "login.php");
    exit(0);
}

$post = false;
$exists = false;
$error = false;

if ($_POST) {
    $post = true;
    $details = Request::getInstance()->all();
    //add project
    addProposal($details);
    $msg = "Added project '" . $details['title'] . "'.";
}
?>
<style> 
body {
background: #262626 !important;
}
</style>

<?php include 'header.php';?>
    <div class="container">
        <div class="content">
            <div class="col-lg-2"></div>
            <div class="col-lg-6" style="margin-top: 50px">
                <div class="panel panel-primary">
                    <div class="panel-heading">Add proposal</div>
                    <div class="panel-body">
                        <?php
                        if ($msg != null && $post) {
                            echo '<div class="alert alert-info alert-dismissable">' .
                                 '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.
                                    $msg .
                                 '</div>';
                        } else if ($msg == null && $post) {
                            echo '<div class="alert alert-danger alert-dismissable">' .
                                 '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.
                                    'Unable to add project!'.
                                 '</div>';
                        }
                        ?>
                        <form class="form-vertical" method="POST" action="add_proposals.php" name="form"
                              enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Project title:</label>
                                <input type="text" class="form-control" name="title">
                            </div>
                            <div class="form-group">
                                <label>Project description:</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Project icon</label>
                                <input type="file" name="pro_icon" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Project documentation</label>
                                <input type="file" name="pro_doc" required class="form-control">
                            </div>
                            <div class="form-group">
                                <div class="pull-right">
                                    <input type="submit" value="Add" class="btn btn-primary">
                                    <input type="reset" value="Clear" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include COMMON_PATH . "footer.php" ?>