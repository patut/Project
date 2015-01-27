<?
	session_start();
	if (isset($_SESSION['id'])) $id = $_SESSION['id'];
	else header('location: /');

	require 'db.php';
	$setonline = mysql_query("UPDATE users SET online='logged_out' WHERE id='$id'", $db);
	session_destroy();
	header("location: /");
?>