<?
    // несмотря на то, что эти параметры проверяются на клиенте, на сервер можно достучаться и не через форму на сайте
    if (isset($_POST['name'])) { $name=$_POST['name']; if ($name =='') { unset($name);} }
    if (isset($_POST['regemail'])) { $regemail=$_POST['regemail']; if ($regemail =='') { unset($regemail);} }
    if (isset($_POST['regpasswd'])) { $regpasswd=$_POST['regpasswd']; if ($regpasswd =='') { unset($regpasswd);} }
    
    if (empty($name) or empty($regemail) or empty($regpasswd)) { exit("* Заполните, пожалуйста, все поля."); }
    else {
        if (strlen($regpasswd)<6) { exit("* Пароль должен состоять из 6 символов или более."); }
        if (strlen($regpasswd)>50) { exit("* Длина пароля не должна превышать 50 символов."); }
    }
    
    function is_email($email2check) {
        $d = 'biz|com|edu|gov|info|int|ru|me|mil|name|net|org|aero|asia|cat|coop|jobs|mobi|museum|pro|tel|travel|arpa|eco|xxx';
        return preg_match(
            '/^[a-z0-9][a-z0-9\-._]*[a-z0-9]@[a-z0-9][a-z0-9\-.]*[a-z0-9]\.('.$d.'|[a-z]{2})$/i',
            $email2check
        );
    }
    if (!is_email($regemail)) { exit("Неправильный email."); }
    
    $name = stripslashes($name);
    $regemail = stripslashes($regemail);
    $regpasswd = stripslashes($regpasswd);

    $name = htmlspecialchars($name);
    $regemail = htmlspecialchars($regemail);
    $regpasswd = htmlspecialchars($regpasswd);
    
    $name = trim($name);
    $regemail = trim($regemail);
    $regpasswd = trim($regpasswd);
    
    require 'db.php';
    mysql_query("SET NAMES utf8");
    
    $result = mysql_query("SELECT id FROM users WHERE email='$regemail'", $db);
    $myrow = mysql_fetch_array($result);
    if (!empty($myrow['id'])) { exit("Аккаунт с данным email уже существует."); } 
    
    $pass = md5($regpasswd);

    // проверка на наличие записей неподтвержденных аккаунтов в базе (не подтверждены более 24 часов)
    $qr = mysql_query("SELECT id,timestamp FROM users WHERE verified='0'", $db);
    while ($account = mysql_fetch_array($qr))
    {
        $diff = strtotime(time()) - strtotime($account['timestamp']);
        $currid = $account['id'];
        if ($diff > 86400) $del = mysql_query("DELETE FROM users WHERE id='$currid'");
    }
    //----------------------//

    $result2 = mysql_query("INSERT INTO users (email,pass,name,img,online) VALUES('$regemail','$pass','$name','http://beoncity.com/img/defava.png','logged_out')");

    if ($result2=='TRUE') { 
        $result3 = mysql_query("SELECT id FROM users WHERE email='$regemail'", $db);
        $myrow3 = mysql_fetch_array($result3);
        $activation = md5($myrow3['id']).md5($regemail);

        $mess = 'Здравствуйте, '.$name.'! Благодарим Вас за регистрацию на сайте beoncity.com<br/>Ваш регистрационный email: '.$regemail.'<br/>Пройдите по данной ссылке, чтобы подтвердить email и активировать аккаунт:<br/><a href="http://beoncity.com/server/activation.php?email='.$regemail.'&code='.$activation.'" target="_blank" title="Активация аккаунта">ссылка для активации аккаунта</a>.';

        $ress = mysql_query("UPDATE users SET activatecode='$activation' WHERE id='".$myrow3['id']."'");

        require 'class.phpmailer.php';

        $mail = new PHPMailer();
        $mail->From = 'noreply@beoncity.com';      // от кого email
        $mail->FromName = 'Beoncity';   // от кого имя
        $mail->AddAddress($regemail, $name); // кому - адрес, Имя
        $mail->IsHTML(true);        // выставляем формат письма HTML
        $mail->Subject = 'Активация аккаунта на Beoncity';  // тема письма
        $mail->Body = $mess;

        if($sendemail != 'No'){
            // отправляем наше письмо
            if (!$mail->Send()) die ('Ошибка при отправке сообщения: '.$mail->ErrorInfo);
            exit("ok");
        }
    }
    else { exit("Неожиданная ошибка..."); }
