<?
	session_start();
	require 'db.php';
	mysql_query("SET NAMES utf8");

	if (isset($_POST['id'])) { 
		$id = $_POST['id'];
		$id = stripslashes($id);
		$id = htmlspecialchars($id);
		$id = trim($id);

		mysql_query("DELETE FROM `comments` WHERE id='$id'", $db);
		echo "ok";
	}
	else die('Bad data.');