<?
    require 'db.php';
    mysql_query("SET NAMES utf8");

    if (isset($_GET['code'])) {$code =$_GET['code']; } 
    if (isset($_GET['email'])) {$email=$_GET['email']; }

    $result = mysql_query("SELECT id FROM users WHERE email='$email'", $db); 
    $myrow = mysql_fetch_array($result); 
    $activation = md5($myrow['id']).md5($email);
    if ($activation == $code) {

        $res = mysql_query("SELECT email,name FROM users WHERE email='$email'", $db); //извлекаем    из базы все данные о пользователе с введенным логином
        $user = mysql_fetch_array($res);

        session_start();
        $_SESSION['name']=$user['name'];
        $_SESSION['email']=$user['email'];
        require 'regform.php';
    }
    else { 
        mysql_query("DELETE FROM users WHERE email='$email'");
        header('location: /');
    }
    