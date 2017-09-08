<?php

require 'paths.php';
require _UTILS_PATH . 'DatabaseConnection.php';
require _UTILS_PATH . 'Request.php';
require _UTILS_PATH . 'functions.php';

if(isLoggedIn()) {
    switch ($_SESSION['userRole'])
    {
        case ADMIN:
            header("Location: " . _ADMIN_PATH . "index.php");
            break;
        case STUDENT:
            header("Location: " . _STUDENT_PATH . "index.php");
            break;
        case CLIENT:
            header("Location: " . _CLIENT_PATH . "index.php");
    }
    exit(0);
}

session_start();
$post = false;
$exists = false;
$error = false;

if ($_POST) {
    $post = true;
    $details = Request::getInstance()->all();
    if(authenticate($details))
    {
        switch ($_SESSION['userRole'])
        {
            case ADMIN:
                header("Location: " . _ADMIN_PATH . "index.php");
                break;
            case STUDENT:
                header("Location: " . _STUDENT_PATH . "index.php");
                break;
            case CLIENT:
                header("Location: " . _CLIENT_PATH . "index.php");
        }
        exit(0);
    }
    else
    {
        $error = true;
    }
}
?>

<?php include 'header.php';?>
<div class="container">
    <div class="content">
        <div class="col-lg-2"></div>
        <div class="col-lg-6" style="margin-top: 50px">
            <div class="panel panel-primary">
                <div class="panel-heading">Log in</div>
                <div class="panel-body">
                    <?php
                    if ($post && $error) {
                        echo "<div class=\"alert alert-danger\">Invalid password or username</div>";
                    }
                    ?>
                    <form class="form-vertical" method="POST" action="login.php" name="form"
                          enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Username:</label>
                            <?php
                            if (isset($_SESSION['username'])) {
                                echo "<input type=\"text\" class=\"form-control\" name=\"username\" value=\"" . $_SESSION['username'] . "\" required>";
                            } else
                                echo "<input type=\"text\" class=\"form-control\" name=\"username\">";
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="password">Password: </label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group">
                            <div class="pull-right">
                                <input type="submit" value="Login" class="btn btn-primary">
                                <input type="reset" value="Clear" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include _COMMON_PATH . "footer.php" ?>