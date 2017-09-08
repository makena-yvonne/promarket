<?php

require '../paths.php';
require UTILS_PATH . 'DatabaseConnection.php';
require UTILS_PATH . 'functions.php';

if(!isAdmin())
{
    header("Location: " . ROOT_PATH . "login.php");
    exit(0);
}

$db = DatabaseConnection::getinstance();

$user = (object)$db->select('users', ['*'], ['id' => currentUserId()])[0];
$proposalCount = count($db->select('projects', ['id'], ['user_id' => currentUserId()]));
?>
<style> 
body {
background: #262626 !important;
}
</style>

<?php include 'header.php';?>
    <div class="container">
        <div class="content">
            <div class="panel panel-primary">
                <div class="panel-heading">PROFILE</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            if (isset($_SESSION['edit_success']) && isset($_SESSION['edit_attempt'])) {
                                echo '<div class="alert alert-info alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' .
                                    $_SESSION['msg'] .
                                    '</div>';
                                unset($_SESSION['edit_success']);
                                unset($_SESSION['edit_attempt']);
                            } else if (isset($_SESSION['edit_attempt'])) {
                                echo '<div class="alert alert-danger alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' .
                                    $_SESSION['msg'] .
                                    '</div>';
                                unset($_SESSION['edit_attempt']);
                            }
                            ?>
                            <div class="form-group">
                                <b>Name:&nbsp</b><?php echo $user->fname . " " . $user->lname;?><br>
                            </div>
                            <div class="form-group">
                                <b>Email:&nbsp</b><?php echo $user->email;?><br>
                            </div>
                            <div class="form-group">
                                <b>Username:&nbsp</b><?php echo $user->username;?><br>
                            </div>
                            <div class="form-group">
                                <b> Registration number:&nbsp</b><?php echo $user->reg_no;?>
                            </div>
                            <div class="form-group">
                                <b>Institution:&nbsp</b> <?php echo $user->institution;?>
                            </div>
                            <div class="form-group">
                                <b>Proposal count:&nbsp</b> <?php echo $proposalCount;?>
                            </div>
                            <a href="<?php echo getBaseUrl() . 'admin/edit_profile.php';?>" class="btn btn-sm btn-primary">
                                Edit profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include COMMON_PATH . "footer.php";?>