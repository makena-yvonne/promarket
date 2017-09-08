<?php

//proposal statuses
define('PENDING', 0);
define('APPROVED', 1);
define('REJECTED', 2);
define('AUTO_REJECTED', 3);

//roles
define('ADMIN', 0);
define('STUDENT', 1);
define('CLIENT', 2);

//match levels
define('TITLE_LEVEL', 90);
define('DESCRIPTION_LEVEL', 85);

//messages
define('UNREAD', 0);
define('READ', 1);

function userExists($username)
{
    $db = DatabaseConnection::getinstance();
    $users = $db->select('users', ['id'], ['username' => $username]);
    if(count($users) > 0)
    {
        return true;
    }
    return false;
}

function authenticate($details)
{
    $password = sha1($details['password']);
    $username = $details['username'];
    $db = DatabaseConnection::getinstance();
    $results = $db->rawQuery(
        "select id, role from users where username='$username' and password ='$password'"
    );
    if(!empty($results) > 0)
    {
        $results = $results[0];
        $user_id = (int)$results['id'];
        $role = (int)$results['role'];
        $_SESSION['login'] = $username;
        $_SESSION['user_id'] = $user_id;
        switch ($role)
        {
            case ADMIN:
                $_SESSION['userRole'] = ADMIN;
                break;
            case STUDENT:
                $_SESSION['userRole'] = STUDENT;
                break;
            case CLIENT:
                $_SESSION['userRole'] = CLIENT;
        }
        return true;
    }
    else
    {
        return false;
    }
}

function isLoggedIn()
{
    session_start();
    if(isset($_SESSION['login']))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function isAdmin()
{
    session_start();
    if(isLoggedIn() && $_SESSION['userRole'] == ADMIN)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function isStudent()
{
    session_start();
    if(isLoggedIn() && $_SESSION['userRole'] == STUDENT)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function isAdminOrStudent()
{
    session_start();
    if(isLoggedIn() && ($_SESSION['userRole'] == STUDENT || $_SESSION['userRole'] == ADMIN))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function isClient()
{
    session_start();
    if(isLoggedIn() && $_SESSION['userRole'] == CLIENT)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function logout()
{
    session_start();
    unset($_SESSION['login']);
    if(isset($_SESSION['userRole']))
    {
        unset($_SESSION['userRole']);
    }
    header("Location: login.php");
}

function currentUserId()
{
    return $_SESSION['user_id'];
}

function currentUserFirstName()
{
    return currentUser()['fname'];
}
function currentUserLastName()
{
    return currentUser()['lname'];
}

function currentUserFullName()
{
    $cUser = currentUser();
    return $cUser['fname'] . " " . $cUser['lname'];
}

function currentUser()
{
    $db = DatabaseConnection::getinstance();
    return $db->select('users', ['*'], ['id' => currentUserId()])[0];
}

function signUp($details)
{
    $db = DatabaseConnection::getinstance();
    if(!userExists($details['username']))
    {
        if ($details['password'] == $details['conf_pass'])
        {
            $details = Request::getInstance()->except('conf_pass');
            //hash the password
            $details['password'] = sha1($details['password']);
            //set role
            //at this point role can either be STUDENT or CLIENT
            if ( !($details['role'] == STUDENT || $details['role'] == CLIENT) )
            {
                $msg = "Unable to sign up.";
                return ['success'=> false, 'msg' => $msg];
            }
            $db->insert('users', $details);
            session_start();
            $_SESSION['signup_successful'] = true;
            $_SESSION['username'] = $details['username'];
            header("Location: login.php");
            return ['success'=> true];
        }
        else
        {
            $msg = "The passwords don't match.";
        }
    }
    else
    {
        $msg = "The username already exists.";
    }
    return ['success'=> false, 'msg' => $msg];
}

function proposalsMatch($request, $titleLevel, $descriptionLevel, & $match)
{
    $db = DatabaseConnection::getinstance();
    //fetch all project descriptions. Compare them with this one
    $other = $db->rawQuery(
        "select * from projects where status <> " . AUTO_REJECTED . " or status <> " . REJECTED
    );
    $percentMatch = 0;
    $percentMatch2 = 0;
    foreach ($other as $item)
    {
        similar_text(strtolower($item['title']), strtolower($request['title']), $percentMatch);
        similar_text(strtolower($request['title']), strtolower($item['title']), $percentMatch2);
        if($percentMatch >= $titleLevel || $percentMatch2 >= $titleLevel)
        {
            $match = ($percentMatch > $percentMatch2) ? $percentMatch : $percentMatch2;
            return true;
        }
        similar_text(strtolower($item['description']), strtolower($request['description']), $percentMatch);
        similar_text(strtolower($request['description']), strtolower($item['description']), $percentMatch2);
        if($percentMatch >= $descriptionLevel || $percentMatch2 >= $descriptionLevel)
        {
            $match = ($percentMatch > $percentMatch2) ? $percentMatch : $percentMatch2;
            return true;
        }
    }
    return false;
}

function addProposal($request)
{
    $match = 0;
    $db = DatabaseConnection::getinstance();
    if(proposalsMatch($request, TITLE_LEVEL, DESCRIPTION_LEVEL, $match))
    {
        $status = AUTO_REJECTED;
    }
    else
    {
        $status = PENDING;
    }
    //add constraint to make project name unique
    $proIcon = $_FILES['pro_icon'];
    $iconPath = md5($proIcon['name']) . "." . substr($proIcon['type'], 6);
    move_uploaded_file($proIcon['tmp_name'], '../pro_icons/' . $iconPath);

    $proDoc = $_FILES['pro_doc'];
    if ($proDoc['type'] != "application/pdf")
    {
        return ['success' => false , 'msg' => 'Documentation must be uploaded in PDF format.'];
    }
    else
    {
        $docPath =  md5($proDoc['name']) . ".pdf";
        move_uploaded_file( $proDoc['tmp_name'], '../pro_documentations/' . $docPath);
    }

    $input['title'] = $request['title'];
    $input['description'] = $request['description'];
    $input['icon_fname'] = $iconPath;
    $input['doc_fname'] = $docPath;
    $input['match_percentage'] = $match;
    $input['status'] = $status;
    $input['action_by']  = null;
    $input['user_id'] = currentUserId();
    $db->insert('projects', $input);
}

function projectStatus($value)
{
    switch ($value)
    {
        case PENDING:
            return "Pending";
        case APPROVED:
            return "Approved";
        case REJECTED:
            return "Rejected";
        case AUTO_REJECTED:
            return "Auto rejected";
    }
}

function approveProposal($request)
{
    $_SESSION['approve_attempt'] = true;
    $db = DatabaseConnection::getinstance();
    $proposal = $request['proposal'];
    $currentUserId = currentUserId();
    $db->update(
        'projects',
        ['action_by' => $currentUserId, 'status' => APPROVED],
        ['id' => $proposal]
    );
    $_SESSION['approve_success'] = true;
    $title = $db->select('projects', ['title'], ['id' => $proposal])[0]['title'];
    $_SESSION['msg'] = "Approved proposal '" . $title . "'.";
}

function rejectProposal($request)
{
    $_SESSION['reject_attempt'] = true;
    $db = DatabaseConnection::getinstance();
    $proposal = $request['proposal'];
    $currentUserId = currentUserId();
    $db->update(
        'projects',
        ['action_by' => $currentUserId, 'status' => REJECTED],
        ['id' => $proposal]
    );
    $_SESSION['reject_success'] = true;
    $title = $db->select('projects', ['title'], ['id' => $proposal])[0]['title'];
    $_SESSION['msg'] = "Rejected proposal '" . $title . "'.";
}

function getBaseUrl()
{
    $url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $str = explode("/", $url);
    return "http://" . $str[count($str) - 4] . "/" . $str[count($str) - 3] . "/";
}

function editProfile($request)
{
    $_SESSION['edit_attempt'] = true;
    $data = [];
    $data['fname'] = $request['fname'];
    $data['lname'] = $request['lname'];
    $data['email'] = $request['email'];
    $data['institution'] = $request['institution'];
    $data['reg_no'] = $request['reg_no'];
    $db = DatabaseConnection::getinstance();
    $db->update(
        'users',
            $data,
            ['id' => currentUserId()]
    );
    $_SESSION['edit_success'] = true;
    $_SESSION['msg'] = "Profile edited.";
    return true;
}

function getCurrentUserApprovedProposals()
{
    $db = DatabaseConnection::getinstance();
    $approved = $db->rawQuery(
        "select
        projects.id as id,
        projects.title as title,
        projects.description as description,
        projects.icon_fname as icon_fname,
        projects.doc_fname as doc_fname,
        projects.status as status,
        projects.updated_at as updated_at,
        (select CONCAT_WS(' ', fname, lname) from users where users.id = projects.user_id) as student,
        (select CONCAT_WS(' ', fname, lname) from users where users.id = projects.action_by) as approver,
        (select count(id) from pro_likes where pro_likes.project_id = projects.id) as likes,
        (select count(id) from pro_likes where 
            pro_likes.project_id = projects.id and pro_likes.user_id =" . currentUserId() . ") as own_like,
        (select count(id) from pro_comments where pro_comments.project_id = projects.id) as comments
        from projects
        where projects.status=" . APPROVED .
        " order by projects.updated_at desc"
    );
    return $approved;
}

function timeAgo($time_ago)
{
    $time_ago = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60){
        return "just now";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return "one minute ago";
        }
        else{
            return "$minutes minutes ago";
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return "an hour ago";
        }else{
            return "$hours hrs ago";
        }
    }
    //Days
    else if($days <= 7){
        if($days==1){
            return "yesterday";
        }else{
            return "$days days ago";
        }
    }
    //Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            return "a week ago";
        }else{
            return "$weeks weeks ago";
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return "a month ago";
        }else{
            return "$months months ago";
        }
    }
    //Years
    else{
        if($years==1){
            return "one year ago";
        }else{
            return "$years years ago";
        }
    }
}

function likeProject($request)
{
    $project = $request['project'];
    $db = DatabaseConnection::getinstance();
    $liked = $db->rawQuery(
        "select id from pro_likes where user_id=" . currentUserId() . " and project_id=". $project
    );
    if (count($liked) < 1)
    {
        //like
        $db->insert('pro_likes', ['user_id' => currentUserId(), 'project_id' => $project]);
        return json_encode(['success' => true]);
    }
    else
    {
        return json_encode(['success' => false]);
    }
}

function unLikeProject($request)
{
    $project = $request['project'];
    $db = DatabaseConnection::getinstance();
    $liked = $db->rawQuery(
        "select id from pro_likes where user_id=" . currentUserId() . " and project_id=". $project
    );
    if (count($liked) > 0)
    {
        //unlike
        $db->rawQuery(
            "delete from pro_likes where user_id=" . currentUserId() . " and project_id=". $project
        );
        return json_encode(['success' => true]);
    }
    else
    {
        return json_encode(['success' => false]);
    }
}

function loadComments($project)
{
    $db = DatabaseConnection::getinstance();
    $comments = $db->rawQuery(
        "select
        pro_comments.id as id,
        pro_comments.comment as comment,
        pro_comments.created_at as created_at,
        (select CONCAT_WS(' ', fname, lname) from users where users.id = pro_comments.user_id) as student
        from pro_comments 
        inner join projects on projects.id = pro_comments.project_id
        where pro_comments.project_id = $project and projects.status=" . APPROVED .
        " order by pro_comments.created_at desc"
    );
    return $comments;
}

function commentNLoad($request)
{
    $project = $request['project'];
    $comment = $request['comment'];
    $db = DatabaseConnection::getinstance();
    $db->insert('pro_comments',
        ['project_id' => $project, 'comment' => $comment, 'user_id' => currentUserId()]
    );
    return loadComments($project);
}

function getProposalTitle($id)
{
    $db = DatabaseConnection::getinstance();
    return $db->select('projects', ['title'], ['id' => $id])[0]['title'];
}

function contact($request)
{
    $_SESSION['contact_attempt'] = true;
    $project = (int)$request['project'];
    $subject = $request['subject'];
    $message = $request['message'];
    DatabaseConnection::getinstance()->insert('messages',
        [
            'project_id' => $project, 'user_id' => currentUserId(),
            'subject' => $subject, 'message' => $message
        ]
    );
    $_SESSION['contact_success'] = true;
}

function adminGetUnreadMessages()
{
    $db = DatabaseConnection::getinstance();
    return $db->rawQuery(
        "select 
         CONCAT_WS(' ', users.fname, users.lname) as client,
         projects.title as proposal, 
         (select  CONCAT_WS(' ', users.fname, users.lname) from users where users.id=projects.user_id) as proposal_owner,
         messages.id as id,
         messages.subject as subject,
         messages.message as message,
         messages.created_at as `time`
         from messages
         inner join projects on messages.project_id = projects.id
         inner join users on messages.user_id = users.id
         where messages.admin_read=". UNREAD
    );
}

function adminGetReadMessages()
{
    $db = DatabaseConnection::getinstance();
    return $db->rawQuery(
        "select 
         CONCAT_WS(' ', users.fname, users.lname) as client,
         projects.title as proposal, 
         (select  CONCAT_WS(' ', users.fname, users.lname) from users where users.id=projects.user_id) as proposal_owner,
         messages.id as id,
         messages.subject as subject,
         messages.message as message,
         messages.created_at as `time`
         from messages
         inner join projects on messages.project_id = projects.id
         inner join users on messages.user_id = users.id
         where messages.admin_read=". READ
    );
}

function studentGetUnreadMessages()
{
    $db = DatabaseConnection::getinstance();
    return $db->rawQuery(
        "select 
         CONCAT_WS(' ', users.fname, users.lname) as client,
         projects.title as proposal, 
         messages.id as id,
         messages.subject as subject,
         messages.message as message,
         messages.created_at as `time`
         from messages
         inner join projects on messages.project_id = projects.id
         inner join users on messages.user_id = users.id
         where messages.student_read=". UNREAD . " and projects.user_id =" . currentUserId()
    );
}

function studentGetReadMessages()
{
    $db = DatabaseConnection::getinstance();
    return $db->rawQuery(
        "select 
         CONCAT_WS(' ', users.fname, users.lname) as client,
         projects.title as proposal, 
         messages.id as id,
         messages.subject as subject,
         messages.message as message,
         messages.created_at as `time`
         from messages
         inner join projects on messages.project_id = projects.id
         inner join users on messages.user_id = users.id
         where messages.student_read=". READ . " and projects.user_id =" . currentUserId()
    );
}

function adminMarkMessageAsRead($msg)
{
    $db = DatabaseConnection::getinstance();
    $db->update('messages', ['admin_read' => READ], ['id' => $msg]);
}

function studentMarkMessageAsRead($msg)
{
    $db = DatabaseConnection::getinstance();
    $db->update('messages', ['student_read' => READ], ['id' => $msg]);
}

function getPendingProposals()
{
    $db = DatabaseConnection::getinstance();
    return $db->rawQuery(
        "select
              projects.id as id,
              projects.title as title,
              projects.description as description,
              projects.icon_fname as icon_fname,
              projects.doc_fname as doc_fname,
              CONCAT_WS(' ', users.fname, users.lname) as student
              from projects 
              inner join users on projects.user_id = users.id
              where projects.status =" . PENDING
    );
}

function getApprovedProposals()
{
    $db = DatabaseConnection::getinstance();
    return $db->rawQuery(
        "select
              projects.id as id,
              projects.title as title,
              projects.description as description,
              projects.icon_fname as icon_fname,
              projects.doc_fname as doc_fname,
              CONCAT_WS(' ', users.fname, users.lname) as student
              from projects 
              inner join users on projects.user_id = users.id
              where projects.status =" . APPROVED
    );
}

function getRejectedProposals()
{
    $db = DatabaseConnection::getinstance();
    return $db->rawQuery(
        "select
              projects.id as id,
              projects.title as title,
              projects.description as description,
              projects.icon_fname as icon_fname,
              projects.doc_fname as doc_fname,
              CONCAT_WS(' ', users.fname, users.lname) as student
              from projects 
              inner join users on projects.user_id = users.id
              where projects.status =" . REJECTED
    );
}

function getAutoRejectedProposals()
{
    $db = DatabaseConnection::getinstance();
    return $db->rawQuery(
        "select
              projects.id as id,
              projects.title as title,
              projects.description as description,
              projects.icon_fname as icon_fname,
              projects.doc_fname as doc_fname,
              projects.match_percentage as match_percentage,
              CONCAT_WS(' ', users.fname, users.lname) as student
              from projects 
              inner join users on projects.user_id = users.id
              where projects.status =" . AUTO_REJECTED
    );
}