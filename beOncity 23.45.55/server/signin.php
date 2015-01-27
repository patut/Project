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
 	
	$result = mysql_query("SELECT * FROM users WHERE email='$email' AND verified='1'", $db); //извлекаем    из базы все данные о пользователе с введенным логином
    $myrow = mysql_fetch_array($result);
    if (empty($pass)) { exit ("Sorry, your credentials are invalid."); }
    else { 
		if ($myrow['pass']==md5($pass)) {
			// если пароль совпадает ...
			$_SESSION['id']=$myrow['id'];
			$_SESSION['name']=$myrow['name'];
			$_SESSION['img']=$myrow['img'];
			echo "ok";
		} 
		else { exit ("Incorrect email or password."); }
	}
?>