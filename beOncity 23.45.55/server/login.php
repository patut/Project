<?
    session_start();
    
	if (isset($_POST['email']) && ($_POST['email']!='')) { $email = $_POST['email']; }
	else exit("noemail");
    if (isset($_POST['pass']) && ($_POST['pass']!='')) { $pass=$_POST['pass']; }
    else exit("nopass");
	
    // фильтруем данные
    $email = stripslashes($email);
    $email = htmlspecialchars($email);
	$pass = stripslashes($pass);
    $pass = htmlspecialchars($pass);
	
	//удаляем лишние пробелы
    $email = trim($email);
    $pass = trim($pass);
	
	// подключаемся к базе
    require 'db.php';
 	mysql_query("SET NAMES utf8");
 	
	$q = mysql_query("SELECT * FROM users WHERE email='$email' AND verified='1'", $db); //извлекаем    из базы все данные о пользователе с введенным логином
    $obj = mysql_fetch_array($q);
    if (empty($pass)) { exit ("Sorry, your credentials are invalid."); }
    else { 
		if ($obj['pass'] == md5($pass)) {
			$_SESSION['id']=$obj['id'];
			$_SESSION['email']=$obj['email'];
			$_SESSION['name']=$obj['name'];
			$_SESSION['img']=$obj['img'];
			$_SESSION['nick']=$obj['nick'];
			echo "ok";
		} 
		else { exit ("Incorrect email or password."); }
	}
?>