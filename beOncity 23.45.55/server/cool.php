<?
	session_start();
	require 'db.php';
	mysql_query("SET NAMES utf8");

	if (isset($_POST['event_id'])) { 
		$event_id = $_POST['event_id'];
		$event_id = stripslashes($event_id);
		$event_id = htmlspecialchars($event_id);
		$event_id = trim($event_id);

		
		$res = mysql_query("INSERT INTO cool (`eventid`) VALUES ('$event_id')");
		if (!$res) { die(mysql_error()); }
		$q = mysql_query("SELECT * FROM events WHERE id='$event_id' ", $db);
		$event = mysql_fetch_array($q);
		$n = (int)$event['cool'] + 1;
		$result = mysql_query("UPDATE events SET cool='$n' WHERE id='$event_id'");
        
		echo 'Ваш отзыв отправлен';
	}
	else die('Bad data.');