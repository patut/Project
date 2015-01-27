<?
	session_start();
	require 'db.php';
	mysql_query("SET NAMES utf8");

	if (isset($_POST['event_id']) && isset($_POST['user_id'])) { 
		$event_id = $_POST['event_id'];
		$event_id = stripslashes($event_id);
		$event_id = htmlspecialchars($event_id);
		$event_id = trim($event_id);
		$user_id = $_POST['user_id'];
		$user_id = stripslashes($user_id);
		$user_id = htmlspecialchars($user_id);
		$user_id = trim($user_id);

		$q = mysql_query("SELECT id FROM willgo WHERE userid='$user_id' AND eventid='$event_id'", $db);
		$usr = mysql_fetch_array($q);
		if (!empty($usr['id'])) { exit('Вы уже отправляли этот отзыв'); }

		
		$res = mysql_query("INSERT INTO willgo (`userid`, `eventid`) VALUES ('$user_id', '$event_id')");
		if (!$res) { die(mysql_error()); }
		$q = mysql_query("SELECT * FROM events WHERE id='$event_id' ", $db);
		$event = mysql_fetch_array($q);
		$n = (int)$event['willGo'] + 1;
		$result = mysql_query("UPDATE events SET willGo='$n' WHERE id='$event_id'");

		echo 'Ваш отзыв отправлен';
	}
	else die('Bad data.');