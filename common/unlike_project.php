<?php

require '../paths.php';
require UTILS_PATH . 'DatabaseConnection.php';
require UTILS_PATH . 'Request.php';
require UTILS_PATH . 'functions.php';

if(!isLoggedIn())
{
    header("Location: " . ROOT_PATH . "login.php");
    exit(0);
}

echo unLikeProject(Request::getInstance()->all());