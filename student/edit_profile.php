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

if ($_POST) {
    $request = Request::getInstance()->all();
    if (editProfile($request))
    {
        header('Location: profile.php');
        exit(0);
    }
}

$db = DatabaseConnection::getinstance();
$user = (object)$db->select('users', ['*'], ['id' => currentUserId()])[0];
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
            <div class="col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">EDIT PROFILE</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST" class="form" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>First Name:</label>
                                        <input type="text" class="form-control" name="fname"
                                               value="<?php echo $user->fname;?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name:</label>
                                        <input type="text" class="form-control" name="lname"
                                               value="<?php echo $user->lname;?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Institution:</label>
                                        <input type="text" class="form-control" name="institution"
                                               value="<?php echo $user->institution;?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Reg No:</label>
                                        <input type="text" class="form-control" name="reg_no"
                                               value="<?php echo $user->reg_no;?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address:</label>
                                        <input type="email" class="form-control" name="email"
                                               value="<?php echo $user->email;?>">
                                    </div>
                                    <div class="form-group">
                                        <div class="pull-right">
                                            <input type="reset" value="Cancel" class="btn btn-primary">
                                            <input type="submit" value="Save" class="btn btn-primary">
                                        </div>
                                    </div>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include COMMON_PATH . "footer.php";?>