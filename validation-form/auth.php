<?php

$login = filter_var(trim($_POST['login']),
FILTER_SANITIZE_SPECIAL_CHARS);
$pass = filter_var(trim($_POST['pass']),
FILTER_SANITIZE_SPECIAL_CHARS);


// strong password
$pass = md5($pass."h9e1l6l8o");

// get data and compare
require "../blocks/connect.php";

$result = $mysql->query("SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'");
$user = $result->fetch_assoc();

if(!isset($user)) {
    echo "User not found";
    exit();
} 

setcookie('user',$user['name'], time() + 3600, "/");

$mysql->close();

// relocate to the form page
header('Location:/');

?>