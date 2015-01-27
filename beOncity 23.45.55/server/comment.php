<?
	session_start();
	require 'db.php';
	mysql_query("SET NAMES utf8");

	if (isset($_POST['text']) && isset($_POST['author_id']) && isset($_POST['event_id']) && isset($_POST['img']) && isset($_POST['name'])) { 
		$author_id = $_POST['author_id'];
		$author_id = stripslashes($author_id);
		$author_id = htmlspecialchars($author_id);
		$author_id = trim($author_id);

		$text = $_POST['text'];
		$text = stripslashes($text);
		$text = htmlspecialchars($text);
		$text = trim($text);

		$event_id = $_POST['event_id'];
		$event_id = stripslashes($event_id);
		$event_id = htmlspecialchars($event_id);
		$event_id = trim($event_id);

		$img = $_POST['img'];
		$img = stripslashes($img);
		$img = htmlspecialchars($img);
		$img = trim($img);

		$name = $_POST['name'];
		$name = stripslashes($name);
		$name = htmlspecialchars($name);
		$name = trim($name);

		// генерация универсального ключа
		$key = md5(date('l jS \of F Y h:i:s A'));
		$res = mysql_query("INSERT INTO comments (`key`,`author_id`, `event_id`,`text`, `author_name`, `author_img`) VALUES ('$key','$author_id', '$event_id','$text', '$name', '$img')");
		if (!$res) { die(mysql_error()); }

		// вытаскиваем по ключу
		$result = mysql_query("SELECT * FROM comments WHERE `key`='$key'", $db);
		$comment = mysql_fetch_array($result);

		$post = '<div id="comm'.$comment['id'].'" class="post">';
			$post .= '<div class="image fl_l"><a href="/user?id='.$author_id.'"><img src="'.$img.'"/></a></div>';
			$post .= '<div class="content fl_l">';
				$post .= '<div class="text">'.$text.'</div>';
				$post .= '<div class="info"><a href="/user?id='.$author_id.'">'.$name.'</a></div>';
			$post .= '</div>';
			if ((isset($_SESSION['id'])) && ($_SESSION['id']==$author_id)) $post .= '<div class="del fl_r"><img onclick="del(\''.$comment['id'].'\')" src="/img/del.png"/></div>';
			$post .= '<div class="clearfix"></div>';
		$post .= '</div>';

		echo $post;

	}
	else die('Bad data.');