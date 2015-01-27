<?
    session_start();
    if (!isset($_SESSION['seenabout'])) $showabout = true;// если пользователь не авторизован, показываем заглушку
    else $showabout = false;

    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id']; 
        $id = stripslashes($id);
        $id = htmlspecialchars($id);
        $id = trim($id);

        require 'server/db.php';
        mysql_query("SET NAMES utf8");

        $q = mysql_query("SELECT * FROM users WHERE id='$id'", $db);
        $user = mysql_fetch_array($q);
        if (empty($user['id'])) header("location: /");
    }
    else header('location: /');

    $item = 'profile';

?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=1200" />
        <meta charset="utf-8" />
        <link type="text/css" rel="stylesheet" href="/css/main.css">
        <link type="text/css" rel="stylesheet" href="/css/settings.css">
        <meta name="application-name" content="Beoncity">
        <meta name="description" content="Beoncity - это платформа для поиска и создания различного рода событий. Здесь вы найдете информацию о разных мероприятиях, встречах, флеш-мобах, экскурсиях и выставках, не освещаемых крупными досуговыми ресурсами, как afisha.ru или kudago.ru. Куда можно пойти с ребёнком, девушкой, друзьями. Сами пользователи рассказывают, куда пойти, создают анонсы, рассказывая другим о происходящих событиях или интересных местах.">
        <meta name="keywords" content="События, время, прогулки, флешмобы, танцы, музыка, фестивали, топ, где, куда, что, куда пойти, что делать, где есть, культура, экстрим, спорт, активный отдых">
        <?php include_once("analyticstracking.php") ?>
        <title>beOncity • настройки</title>
    </head>
    <body>
        <section id="header">
            <a href="/" id="logo" class="fl_l">beOncity</a>
            <?

                if (isset($_SESSION['id'])) echo '<a href="/server/signout" id="signout" class="fl_r">Выйти</a>';
                //if (isset($_SESSION['id'])) echo '<a href="/settings" id="settings" class="fl_r">Настройки</a>';
                else echo '<a href="/register" id="registration" class="fl_r">Войти</a>';
            ?>
            <? require 'header.php'; ?>
            <div class="clearfix"></div>
        </section>
        <section id="wrap">
            <div id="mainblock">
                <div id="tophead">Настройки профиля</div>
                <div id="table">
                    <div class="row">
                        <div class="key">Отображаемое имя</div>
                        <input type="text" id="name" value="<? echo $user['name']; ?>" onKeyDown="limitText(this,50)" onKeyUp="limitText(this,50)" maxlength="50" class="value">
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="key">Ваш Email</div>
                        <? 
                            if (empty($user['email'])) $attr = ' placeholder="your@email.com" '; 
                            else $attr = ' value="'.$user['email'].'" ';
                        ?>
                        <input type="email" id="email" <? echo $attr; ?> class="value">
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="key">Номер телефона</div>
                        <? 
                            if(empty($user['phone'])) $attr = ' placeholder="79031234567" '; 
                            else $attr = ' value="'.$user['phone'].'" ';
                        ?>
                        <input type="text" id="phone" <?echo $attr;?> onKeyDown="limitText(this,11)" onKeyUp="limitText(this,11)" maxlength="11" class="value">
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="key">Немного о себе</div>
                        <? 
                            if(empty($user['about'])) { $attr = ' placeholder="Я ..." '; }
                            else { $attr = ''; $val = $user['about']; }
                        ?>
                        <textarea rows="10" id="about" cols="40" onKeyDown="limitText(this,300)" onKeyUp="limitText(this,300)" maxlength="300" <?echo $attr;?> class="value"><? echo $val;?></textarea>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="key">Где вас можно найти?</div>
                        <? 
                            if(empty($user['location'])) $attr = ' placeholder="Москва, Россия" '; 
                            else $attr = ' value="'.$user['location'].'" ';
                        ?>
                        <input type="text" id="loc" <?echo $attr;?> class="value">
                        <div class="clearfix"></div>
                    </div>
                    <form style="height:0;overflow:hidden" method="post" action="/server/e-upload.php" id="uploadform" enctype="multipart/form-data">
                        <table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
                            <tr> 
                                <td width="246">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="10240000">
                                    <input name="userfile" accept="image" type="file" id="userfile">
                                    <input name="id" id="fileid" type="hidden" value="">
                                </td>
                                <td width="80">
                                    <input name="upload" type="submit" class="box" id="upload" value=" Выбрать ">
                                </td>
                            </tr>
                        </table>
                    </form>
                    <div class="item">
                        <div class="image fl_l"><img src="/img/image.png" alt="icon"/></div>
                        <div id="chooseImg" class="fl_r">Выбрать</div>
                        <div class="text fl_l" id="filename"><input type="text" id="filenameholder" placeholder="Изображение" readonly/></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="left">Сменить аватар</div>
                    <div class="clearfix"></div>
                </div>
                <div id="submit">Сохранить</div>
                <div id="error"></div>
                <div id="userid" style="display:none"><?echo $user['id'];?></div>
                <div class="clearfix"></div>
            </div>
            <? require 'sidebar.php'; ?>
            <div class="clearfix"></div>
        </section>
        <? require 'footer.php'; ?>
        <script type="text/javascript" src="/js/general.js"></script>
        <script type="text/javascript" src="/js/ajax.js"></script>
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="/js/jquery.form.min.js"></script>
        <script>
        function limitText(limitField, limitNum) {
            if (limitField.value.length > limitNum) {
                limitField.value = limitField.value.substring(0, limitNum);
            }
        }
        var item = '<? echo $item; ?>';
        var id = '<? echo $user["id"]; ?>';

        </script>
        <script type="text/javascript" src="/js/set.js"></script>
    </body>
</html>