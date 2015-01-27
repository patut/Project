<?
    session_start();
    
	if (isset($_POST['userid']) && ($_POST['userid']!='')) { $id = $_POST['userid']; }
	else exit("noemail");
    if (isset($_POST['old']) && ($_POST['old']!='')) { $old=$_POST['old']; }
    else exit("nopass");
    if (isset($_POST['new']) && ($_POST['new']!='')) { $new=$_POST['new']; }
    else exit("nopass");
	
    // фильтруем данные
    $id = stripslashes($id);
    $id = htmlspecialchars($id);
	$old = stripslashes($old);
    $old = htmlspecialchars($old);
	$new = stripslashes($new);
    $new = htmlspecialchars($new);

	//удаляем лишние пробелы
    $id = trim($id);
    $old = trim($old);
    $new = trim($new);
	
	// подключаемся к базе
    require 'db.php';
 	mysql_query("SET NAMES utf8");

 	$result = mysql_query("SELECT * FROM users WHERE id='$id' AND verified='1'", $db); //извлекаем    из базы все данные о пользователе с введенным логином
    $myrow = mysql_fetch_array($result);
	if ($myrow['pass']==md5($old)) {
		$pass = md5($new);
		$result = mysql_query("UPDATE users SET pass='$pass' WHERE id='$id'");
		if (!$result) { die(mysql_error()); }
		echo "ok";
	} 
	else { exit ("Неверный пароль."); }
?>