<?php

require '../paths.php';
require UTILS_PATH . 'Request.php';
require UTILS_PATH . 'functions.php';

if(!isAdminOrStudent())
{
    header("Location: " . ROOT_PATH . "login.php");
    exit(0);
}

$request = Request::getInstance()->all();

$picture = $request['name'];
$picture = PRO_ICONS_PATH . $picture;
?>
<img src="<?php echo $picture?>" style="max-width: 100%" alt="Image unavailable">;