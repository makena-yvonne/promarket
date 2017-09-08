<?php

require '../paths.php';
require UTILS_PATH . 'DatabaseConnection.php';
require UTILS_PATH . 'Request.php';
require UTILS_PATH . 'functions.php';

if(!isAdmin())
{
    header("Location: " . ROOT_PATH . "login.php");
    exit(0);
}

$request = Request::getInstance()->all();
approveProposal($request);

header('location: pending_proposals.php');
exit(0);