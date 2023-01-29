<?php

    // get data from supper global array
    $login = filter_var(trim($_POST['login']),
    FILTER_SANITIZE_SPECIAL_CHARS);
    $name = filter_var(trim($_POST['name']),
    FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var(trim($_POST['email']),
    FILTER_VALIDATE_EMAIL);
    $pass = filter_var(trim($_POST['pass']),
    FILTER_SANITIZE_SPECIAL_CHARS);
    $pass_confirm = filter_var(trim($_POST['pass_confirm']),
    FILTER_SANITIZE_SPECIAL_CHARS);

    // regular expresions for checking
    $regExp = "/[0-9]/";
    $regExp2 = "/[a-z]/i";
    
    // get database
    require "../blocks/connect.php";
    // check the login
    $log = $mysql->query("SELECT `login` FROM `users` WHERE `login` = '$login'");
    $userLog = $log->fetch_assoc();

    // check the email
    $mail = $mysql->query("SELECT `email` FROM `users` WHERE `email` = '$email'");
    $userEmail = $mail->fetch_assoc();

    // check conditions
    if(mb_strlen($login) < 6 || mb_strlen($login) > 90) {
        echo 'Login length is not correct';
        exit();
    }else if(isset($userLog)) {
        echo "The login is already exist";
        exit();
    }else if (mb_strlen($name) < 2) {
        echo 'Name length is not correct';
        exit();
    }else if (preg_match($regExp, $name)) {
        echo 'The name must not contain numbers';
        exit();
    }else if (!$email) {
        echo 'E-mail is not correct';
        exit();
    }else if (isset($userEmail)) {
        echo 'The E-mail is already exist';
        exit();
    }else if (mb_strlen($pass) < 6) {
        echo 'Password is not correct';
        exit();
    }else if (!preg_match($regExp, $pass)) {
        echo "You password doesn't have numbers";
        exit();
    }else if (!preg_match($regExp2, $pass)) {
        echo "You password doesn't have letters";
        exit();
    }else if ($pass !== $pass_confirm) {
        echo 'Password is not correct';
        exit();
    }

    // create strong password
    $pass = md5($pass."h9e1l6l8o");

    // push data to sql table
    require "../blocks/connect.php";

    $mysql->query("INSERT INTO users (`login`, `pass`, `name`, `email`)
    VALUES ('$login', '$pass', '$name', '$email')");
    $mysql->close();

    // relocate to the form page
    header('Location:/');
?>