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

    $item = 'password';

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
                else echo '<a href="/register" id="registration" class="fl_r">Войти / Регистрация</a>';

                require 'header.php';
            ?>
            <div class="clearfix"></div>
        </section>
        <section id="wrap">
            <div id="mainblock">
                <div id="tophead">Смена пароля</div>
                <div id="table">
                    <div class="row">
                        <div class="key">Прошлый пароль</div>
                        <input type="password" id="oldpass" onKeyDown="limitText(this,60)" onKeyUp="limitText(this,60)" maxlength="60" class="value">
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="key">Новый пароль</div>
                        <input type="password" id="newpass" onKeyDown="limitText(this,60)" onKeyUp="limitText(this,60)" maxlength="60" class="value">
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="key">Подтвердите</div>
                        <input type="password" id="confirm" onKeyDown="limitText(this,60)" onKeyUp="limitText(this,60)" maxlength="60" class="value">
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div id="submit">Сохранить</div>
                <div id="error"></div>
                <div id="userid" style="display:none"><? echo $user["id"]; ?></div>
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
        </script>
        <script type="text/javascript" src="/js/set.js"></script>
    </body>
</html>