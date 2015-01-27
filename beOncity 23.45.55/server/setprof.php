<?
if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['about']) && isset($_POST['phone']) && isset($_POST['location'])) { 
	
	$id = $_POST['id'];
	$id = stripslashes($id);
	$id = htmlspecialchars($id);
	$id = trim($id);

	$email = $_POST['email'];
	$email = stripslashes($email);
	$email = htmlspecialchars($email);
	$email = trim($email);
	
	$name = $_POST['name'];
	$name = stripslashes($name);
	$name = htmlspecialchars($name);
	$name = trim($name);

	$about = $_POST['about'];
	$about = stripslashes($about);
	$about = htmlspecialchars($about);
	$about = trim($about);

	$phone = $_POST['phone'];
	$phone = stripslashes($phone);
	$phone = htmlspecialchars($phone);
	$phone = trim($phone);

	$location = $_POST['location'];
	$location = stripslashes($location);
	$location = htmlspecialchars($location);
	$location = trim($location);

	function is_email($email2check) {
        $d = 'biz|com|edu|gov|info|int|ru|me|mil|name|net|org|aero|asia|cat|coop|jobs|mobi|museum|pro|tel|travel|arpa|eco|xxx';
        return preg_match(
            '/^[a-z0-9][a-z0-9\-._]*[a-z0-9]@[a-z0-9][a-z0-9\-.]*[a-z0-9]\.('.$d.'|[a-z]{2})$/i',
            $email2check
        );
    }
    if (!is_email($email)) { exit("Некорректный адрес email."); }

	require 'db.php';
	mysql_query("SET NAMES utf8");
	mysql_query("UPDATE users SET email='$email',verified='1',name='$name',about='$about',location='$location',phone='$phone' WHERE id='$id'", $db);

	$res = mysql_query("SELECT * FROM users WHERE id='$id'", $db); //извлекаем    из базы все данные о пользователе с введенным логином
	$user = mysql_fetch_array($res);

	session_start();
	$_SESSION['id']=$user['id'];
	$_SESSION['seenabout']= 'seen';

	$setonline = mysql_query("UPDATE users SET online='logged_in' WHERE id='$id'", $db);
	echo 'ok';
}
else die('error');
