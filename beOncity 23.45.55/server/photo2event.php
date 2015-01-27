<?
	require 'db.php';
	mysql_query("SET NAMES utf8");

	if (isset($_POST['id']) && isset($_POST['name'])) { 
		$id = $_POST['id'];
		$id = stripslashes($id);
		$id = htmlspecialchars($id);
		$id = trim($id);
		$name = $_POST['name'];
		$name = stripslashes($name);
		$name = htmlspecialchars($name);
		$name = trim($name);

		require 'db.php';
		mysql_query("SET NAMES utf8");

		$q = mysql_query("SELECT * FROM users WHERE id='$id'", $db);
		if (!$q) { die(mysql_error()); }
        $user = mysql_fetch_array($q);
		unlink($user['img']);

		// добавляем фотографию к событию
		$result = mysql_query("UPDATE events SET img='$name' WHERE id='$id'");
		if (!$result) { die(mysql_error()); }
		echo $id.'ok'.$name;
	}
	else die('error');