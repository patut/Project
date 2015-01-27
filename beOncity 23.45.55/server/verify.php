<?
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['about']) && isset($_POST['phone']) && isset($_POST['location'])) { 
		
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

	require 'db.php';
	mysql_query("SET NAMES utf8");
	mysql_query("UPDATE users SET verified='1',name='$name',about='$about',location='$location',phone='$phone' WHERE email='$email'", $db);

	$res = mysql_query("SELECT * FROM users WHERE email='$email'", $db); //извлекаем    из базы все данные о пользователе с введенным логином
	$user = mysql_fetch_array($res);

	session_start();
	$_SESSION['id']=$user['id'];
	$_SESSION['img']=$user['img'];
	$_SESSION['name']=$user['name'];
	$_SESSION['about']=$user['about'];
	$_SESSION['email']=$user['email'];
	if (!empty($user['phone'])) $_SESSION['phone']=$user['phone'];
	$_SESSION['seenabout']= 'seen';

	$setonline = mysql_query("UPDATE users SET online='logged_in' WHERE email='$email'", $db);
	echo 'ok';
}
else die('error');
