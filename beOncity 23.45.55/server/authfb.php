<?
require 'db.php';
mysql_query("SET NAMES utf8");
if (isset($_GET['id']) && isset($_GET['name']) && isset($_GET['surname']) && isset($_GET['email'])) { 
	$id = $_GET['id']; 
	$id = stripslashes($id);
	$id = htmlspecialchars($id);
	$id = trim($id);
	$id = wordwrap($id, 530, "<br />\n");
	$name =$_GET['name']; 
	$name = stripslashes($name);
	$name = htmlspecialchars($name);
	$name = trim($name);
	$email =$_GET['email']; 
	$email = stripslashes($email);
	$email = htmlspecialchars($email);
	$email = trim($email);
	$surname =$_GET['surname']; 
	$surname = stripslashes($surname);
	$surname = htmlspecialchars($surname);
	$surname = trim($surname);
	$avatar =$_GET['avatar']; 
	$avatar = stripslashes($avatar);
	$avatar = htmlspecialchars($avatar);
	$avatar = trim($avatar);
	$avatar_big = $avatar;
	if ($id =='') { unset($id); exit('An error occurred. No user id.'); } 
	if ($name =='') { unset($name); exit('An error occurred. No user name'); } 
	if ($surname =='') { unset($surname); exit('An error occurred. No user surname'); } 
	
	session_start();
	session_destroy();
	session_start();
	$result = mysql_query("SELECT id FROM users WHERE auth_id='$id'", $db);
	$myrow = mysql_fetch_array($result);
	$uname = $name.' '.$surname;
	if (empty($myrow['id'])) { mysql_query ("INSERT INTO users (`auth_id`, `name`, `email`, `verified`, `online`, `img`) VALUES('$id','$uname','$email','1', 'logged_in','$avatar') "); }		
	else { 
		if($myrow['img']!=$avatar) mysql_query ( "UPDATE users SET img='$avatar' WHERE auth_id='$id'");
		mysql_query ("UPDATE users SET online='logged_in' WHERE email='$email' ");
	}
	$_SESSION['id']=$myrow['id'];
	$_SESSION['email']=$email;
	$_SESSION['name']=$uname;
	$_SESSION['seenabout']= 'seen';
	header("location: /");
}
else die;