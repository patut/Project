<?
    session_start();
    if (!isset($_SESSION['seenabout'])) $showabout = true;// если пользователь не авторизован, показываем заглушку
    else $showabout = false;

    $myid = $_SESSION['id']; // ввожу данные своего аккаунта (ALexey Khan/axenkhan) -> далее авторизация и регистрация
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=1200" />
        <meta charset="utf-8" />
        <link type="text/css" rel="stylesheet" href="/css/main.css">
        <link type="text/css" rel="stylesheet" href="/css/regform.css">
        <meta name="application-name" content="Beoncity">
        <meta name="description" content="Beoncity - это платформа для поиска и создания различного рода событий. Здесь вы найдете информацию о разных мероприятиях, встречах, флеш-мобах, экскурсиях и выставках, не освещаемых крупными досуговыми ресурсами, как afisha.ru или kudago.ru. Куда можно пойти с ребёнком, девушкой, друзьями. Сами пользователи рассказывают, куда пойти, создают анонсы, рассказывая другим о происходящих событиях или интересных местах.">
        <meta name="keywords" content="События, время, прогулки, флешмобы, танцы, музыка, фестивали, топ, где, куда, что, куда пойти, что делать, где есть, культура, экстрим, спорт, активный отдых">
        <?php include_once("../analyticstracking.php") ?>
        <title>beOncity • активация аккаунта</title>
    </head>
    <body>
        <section id="header">
            <a href="/" id="logo" class="fl_l">beOncity</a>
            <nav id="topmenu">
                <a href="#" class="item current">Активация Вашего аккаунта</a>
                <div class="clearfix"></div>
            </nav>
            <div class="clearfix"></div>
        </section>
        <section id="wrap">
            <div id="tophead">Последние шаги</div>
            <div id="table">
                <div class="row">
                    <div class="key">Отображаемое имя *</div>
                    <input type="text" id="name" value="<? echo $_SESSION['name']; ?>" onKeyDown="limitText(this,50)" onKeyUp="limitText(this,50)" maxlength="50" class="value">
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="key">Ваш Email *</div>
                    <input type="email" id="email" value="<? echo $_SESSION['email']; ?>" class="value" readonly>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="key">Номер телефона</div>
                    <input type="text" id="phone" placeholder="79031234567" onKeyDown="limitText(this,11)" onKeyUp="limitText(this,11)" maxlength="11" class="value">
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="key">Немного о себе *</div>
                    <textarea rows="10" id="about" cols="40" onKeyDown="limitText(this,300)" onKeyUp="limitText(this,300)" maxlength="300" placeholder="Я ..." class="value"></textarea>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="key">Где вас можно найти? *</div>
                    <input type="text" id="loc" placeholder="Москва, Россия" class="value">
                    <div class="clearfix"></div>
                </div>
            </div>
            <div id="submit">Активировать аккаунт</div>
            <div id="error"></div>
            <div class="clearfix"></div>
        </section>
        <? require '../footer.php'; ?>
        <script type="text/javascript" src="/js/general.js"></script>
        <script type="text/javascript" src="/js/ajax.js"></script>
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="/js/verify.js"></script>
        <script>
        function limitText(limitField, limitNum) {
            if (limitField.value.length > limitNum) {
                limitField.value = limitField.value.substring(0, limitNum);
            }
        }
        </script>
    </body>
</html>