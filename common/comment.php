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

$request = Request::getInstance()->all();

$comments = null;
if(isset($request['load']))
{
    //load comments
    $comments = loadComments($request['project']);
}
else if(isset($request['comment']))
{
    //comment and load comments
    $comments = commentNLoad($request);
}

if (count($comments) > 0)
{
    $allComments = "";
    foreach ($comments as $comment)
    {
        $allComments .= '<div class="panel panel-primary panel-body">';
        $allComments .= '<b>' . $comment['student'] . '</b>';
        $allComments .= '<div>' . $comment['comment'] . '</div>';
        $allComments .= '<div>' . timeAgo($comment['created_at']) . '</div>';
        $allComments .= '</div>';
    }
    echo json_encode(
        [
            'title' => getProposalTitle($request['project']),
            'comments' => $allComments
        ]
    );
}
else
{
    echo json_encode(
        [
            'title' => getProposalTitle($request['project']),
            'comments' => ""
        ]
    );
}