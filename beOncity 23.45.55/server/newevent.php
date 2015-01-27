<?
	session_start();
	require 'db.php';
	mysql_query("SET NAMES utf8");

	if (isset($_POST['title']) && isset($_POST['author']) && isset($_POST['ru']) && isset($_POST['desc']) && isset($_POST['en']) && isset($_POST['lat']) && isset($_POST['long']) && isset($_POST['date']) && isset($_POST['filter'])) { 
		$author = $_POST['author'];
		$author = stripslashes($author);
		$author = htmlspecialchars($author);
		$author = trim($author);
		$ru = $_POST['ru'];
		$ru = stripslashes($ru);
		$ru = htmlspecialchars($ru);
		$ru = trim($ru);
		$en = $_POST['en'];
		$en = stripslashes($en);
		$en = htmlspecialchars($en);
		$en = trim($en);
		$date = $_POST['date'];
		$date = stripslashes($date);
		$date = htmlspecialchars($date);
		$date = trim($date);
		$desc = $_POST['desc'];
		$desc = stripslashes($desc);
		$desc = htmlspecialchars($desc);
		$desc = trim($desc);
		$filter = $_POST['filter'];
		$filter = stripslashes($filter);
		$filter = htmlspecialchars($filter);
		$filter = trim($filter);
		$lat = $_POST['lat'];
		$lat = stripslashes($lat);
		$lat = htmlspecialchars($lat);
		$lat = trim($lat);
		$long = $_POST['long'];
		$long = stripslashes($long);
		$long = htmlspecialchars($long);
		$long = trim($long);
		$title = $_POST['title'];
		$title = stripslashes($title);
		$title = htmlspecialchars($title);
		$title = trim($title);

		$en = addslashes($en);
		$ru = addslashes($ru);
		$title = addslashes($title);
		$desc = addslashes($desc);

		$m = array(
			'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'September',
			'October',
			'November',
			'December'
		);


		$splited = explode(' ',$date);
		$day = substr($splited[1], 0, strlen($splited[1]) - 1);
		$year = $splited[2];
		$time = $splited[5];
		$month = $splited[0];
		for ($i=0;$i<12;$i++){
			if ($m[$i] == $month) {
				$month = $i + 1;
				break;
			}
		}
		//$time = substr($time,1,strlen($time)-1);
		$time = explode(':', $time);
		$hour = $time[0];
		$minute = $time[1];

		$s = $day.'/'.$month.'/'.$year.' '.$hour.':'.$minute.':00';
		//$s = "12/1/1995 00:10:00";
		$datetime = date_create_from_format('d/m/Y H:i:s', $s);
		//$datetime->getTimestamp();
		// генерация универсального ключа
		$key = md5($title.$desc);
		$res = mysql_query("INSERT INTO events (`key`, `author_id`, `title`, `desc`, `filter`, `year`, `month`,`day`,`hour`,`minute`,`addressRU`, `addressEN`, `latitude`, `longitude`) VALUES ('$key', '$author', '$title', '$desc', '$filter', '$year', '$month', '$day', '$hour', '$minute', '$ru', '$en', '$lat', '$long' ) ");
		if (!$res) { die(mysql_error()); }

		// вытаскиваем по ключу
		$result = mysql_query("SELECT `id` FROM events WHERE `key`='$key'", $db);
		$event = mysql_fetch_row($result);

		echo $event[0];

	}
	else die('Bad data.');