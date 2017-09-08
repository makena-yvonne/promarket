<!DOCTYPE html>
<html>
<head>
    <title>Project Market | Home</title>
    <!--link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css"!-->
    <?php include '_links.php'?>
</head>
<body>
<input type="hidden" id="base_url" value="<?php echo getBaseUrl()?>">
<nav class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Project Market</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li>
                <a href="index.php">Home</a>
            </li>
            <li class=""><a href="sign_up.php">Sign up </a></li>
            <li class=""><a href="login.php">Login</a></li>
        </ul>
    </div>
</nav>