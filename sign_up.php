<?php

require 'paths.php';
require _UTILS_PATH . 'DatabaseConnection.php';
require _UTILS_PATH . 'Request.php';
require _UTILS_PATH . 'functions.php';

$msg = null;

if ($_POST) {
    $details = Request::getInstance()->all();
    $status = signUp($details);
    if (!$status['success']) {
        $msg = $status['msg'];
    }
}
?>

<?php include 'header.php';?>
<div class="container">
    <div class="content">
        <div class="col-lg-2"></div>
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Sign up</div>
                <div class="panel-body">
                    <?php
                    if ($msg != null)
                        echo "<div class=\"alert alert-danger\">$msg</div>";
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <form method="POST" action="sign_up.php" name="form" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>First Name:</label>
                                    <input type="text" class="form-control" name="fname" required="">
                                </div>
                                <div class="form-group">
                                    <label>Last Name:</label>
                                    <input type="text" class="form-control" name="lname" required="">
                                </div>
                                <div class="form-group">
                                    <label>Student / Client:</label>
                                    <select class="form-control" name="role" required="">
                                        <option value="1">Student</option>
                                        <option value="2">Client</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Reg No:</label>
                                    <input type="text" class="form-control" name="reg_no" required="">
                                </div>
                                <div class="form-group">
                                    <label>Institution:</label>
                                    <input type="text" class="form-control" name="institution" required="">
                                </div>
                                <div class="form-group">
                                    <label>Email Address:</label>
                                    <input type="email" class="form-control" name="email" required="">
                                </div>
                                <div class="form-group">
                                    <label>Username:</label>
                                    <input type="text" class="form-control" name="username" required="">
                                </div>
                                <div class="form-group">
                                    <label>Password:</label>
                                    <input type="password" class="form-control" name="password" required="">
                                </div>
                                <div class="form-group">
                                    <label>Confirm password:</label>
                                    <input type="password" class="form-control" name="conf_pass" required="">
                                </div>
                                <div class="form-group">
                                    <div class="pull-right">
                                        <input type="submit" value="Sign me up" class="btn btn-primary">
                                        <input type="reset" value="Clear" class="btn btn-primary">
                                    </div>
                                </div>
                                <div><a href="login.php">Login</a></div>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include _COMMON_PATH . 'footer.php';?>