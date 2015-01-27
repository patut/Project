<?
if (empty($_POST['uid'])) { header("location: /"); exit("no_id"); }

require 'db.php';
mysql_query("SET NAMES utf8");

$name=$_POST['name'];
$surname=$_POST['surname'];
$uid=$_POST['uid'];
$photo_max_orig=$_POST['photo_max_orig'];
$city=$_POST['city'];
$country=$_POST['country'];


$name = stripslashes($name);
$name = htmlspecialchars($name);
$name = trim($name);
$surname = stripslashes($surname);
$surname = htmlspecialchars($surname);
$surname = trim($surname);
$uid = stripslashes($uid);
$uid = htmlspecialchars($uid);
$uid = trim($uid);
$photo_max_orig= stripslashes($photo_max_orig);
$photo_max_orig= htmlspecialchars($photo_max_orig);
$photo_max_orig= trim($photo_max_orig);

session_start();
session_destroy();
session_start();

$user_find = mysql_query("SELECT * FROM users WHERE `auth_id` = '$uid'", $db);
$user = mysql_fetch_array($user_find);

if (empty($user['id'])) { // если нет таких пользователей, создаем нового
	$uName = $name.' '.$surname;
	mysql_query ("INSERT INTO users (`auth_id`,`name`, `verified`, `online`) VALUES('$uid','$uName','1', 'logged_in') "); 
	$user_find2 = mysql_query("SELECT * FROM users WHERE auth_id = '$uid'", $db);
	$user2 = mysql_fetch_array($user_find2);

	$_SESSION['id']=$user2['id'];
	if ($photo_max_orig != 'https://vk.com/images/camera_a.gif') {mysql_query ( "UPDATE users SET img='$photo_max_orig' WHERE auth_id='$uid'");}

	//if (!empty($city)) { $loc = $city; }
	//if (!empty($country)) { if(!empty($loc)) $loc .= ', '.$country; else $loc = $country; }
	$loc = 'Москва, Россия';
	
	//if ((!empty($city)) || (!empty($country))) 
	mysql_query ( "UPDATE users SET location='$loc' WHERE auth_id='$uid'");
}
else { // если есть - обновляем инфу о его активности
	mysql_query ( "UPDATE users SET online='logged_in' WHERE auth_id='$uid'");  
	$_SESSION['id']=$user['id'];
}
$_SESSION['seenabout']= 'seen';
//echo $user['name'].' '.$user['auth_id'];
echo "ok";