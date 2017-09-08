<!DOCTYPE html>
<html>
<head>
    <title>Project Market | Contact us</title>
    <!--link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css"!-->
    <?php include ROOT_PATH . 'links.php'?>
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
                <a href="profile.php">Profile</a>
            </li>
            <li>
                <a href="timeline.php">Timeline</a>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Proposals
                    <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="pending_proposals.php">Pending</a></li>
                    <li><a href="approved_proposals.php">Approved</a></li>
                    <li><a href="rejected_proposals.php">Rejected</a></li>
                    <li><a href="auto_rejected_proposals.php">Auto Rejected</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Messages
                    <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="read_messages.php">Read messages</a></li>
                    <li><a href="unread_messages.php">Unread messages</a></li>
                </ul>
            </li>
            <li class="">
                <a href="<?php echo ROOT_PATH . 'logout.php'?>"> Logout: <?php echo $_SESSION['login']?></a>
            </li>
        </ul>
    </div>
</nav>