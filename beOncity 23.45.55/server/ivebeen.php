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

		$q = mysql_query("SELECT id FROM beento WHERE userid='$user_id' AND eventid='$event_id' ", $db);
		$usr = mysql_fetch_array($q);
		if (!empty($usr['id'])) { exit('Вы уже отправляли этот отзыв'); }

		$qw = mysql_query("SELECT * FROM events WHERE id='$event_id' ORDER BY timestamp DESC", $db);
	    while ($event = mysql_fetch_array($qw)) {

	        if ((int)$event['month'] < 10) $event['month'] = '0'.$event['month'];
	        if ((int)$event['day'] < 10) $event['day'] = '0'.$event['day'];
	        if ((int)$event['hour'] < 10) $event['hour'] = '0'.$event['hour'];
	        if ((int)$event['minute'] < 10) $event['minute'] = '0'.$event['minute'];


	        $date = $event['year'].'/'.$event['month'].'/'.$event['day']; 
	        $date = explode("/", $date); 
	        
	        $time = $event['hour'].'/'.$event['minute'].'/00'; 
	        $time = explode(":", $time); 
	        
	        $tz_string = "Europe/Moscow";
	        $tz_object = new DateTimeZone($tz_string); 
	        
	        $datetime = new DateTime(); 
	        $datetime->setTimezone($tz_object);
	        $datetime->setDate($date[0], $date[1], $date[2]); 
	        $datetime->setTime($time[0], $time[1], $time[2]); 


	        //$datetime->format('Y/m/d H:i:s')
	        $today = date("Y/m/d");
	        $datetime = $datetime->format('Y/m/d');

	        if ($today < $datetime) exit('Событие еще даже не наступило :)');
	    }

		
		$res = mysql_query("INSERT INTO beento (`userid`, `eventid`) VALUES ('$user_id', '$event_id')");
		if (!$res) { die(mysql_error()); }
		$q = mysql_query("SELECT * FROM events WHERE id='$event_id' ", $db);
		$event = mysql_fetch_array($q);
		$n = (int)$event['visited'] + 1;
		$result = mysql_query("UPDATE events SET visited='$n' WHERE id='$event_id'");

		echo 'Ваш отзыв отправлен';
	}
	else die('Bad data.');