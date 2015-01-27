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
        <link type="text/css" rel="stylesheet" href="/css/reg.css">
        <link type="text/css" rel="stylesheet" href="/css/login.css">
        <meta name="application-name" content="Beoncity">
        <meta name="description" content="Beoncity - это платформа для поиска и создания различного рода событий. Здесь вы найдете информацию о разных мероприятиях, встречах, флеш-мобах, экскурсиях и выставках, не освещаемых крупными досуговыми ресурсами, как afisha.ru или kudago.ru. Куда можно пойти с ребёнком, девушкой, друзьями. Сами пользователи рассказывают, куда пойти, создают анонсы, рассказывая другим о происходящих событиях или интересных местах.">
        <meta name="keywords" content="События, время, прогулки, флешмобы, танцы, музыка, фестивали, топ, где, куда, что, куда пойти, что делать, где есть, культура, экстрим, спорт, активный отдых">
        <?php include_once("analyticstracking.php") ?>
        <title>beOncity • регистрация</title>
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
            <div id="signinblock" class="fl_l">
                <div id="loginform">
                    <div class="title">Авторизация</div>
                    <div class="field" id="emailField"><input type="email" id="email" placeholder="Email"></div>
                    <div class="field" id="passField"><input type="password" id="pass" placeholder="Пароль"></div>
                    <div class="button" id="signin">Войти</div>
                    <div id="loginerror"></div>
                    <div id="social">
                        <div id="centeredS">
                            <div class="text">Войти через:</div>
                            <div class="fl_l" id="vk" onclick="VK.Auth.login(authInfo)"><img src="/img/vk.png"></div>
                            <div class="fl_l" id="fb"><img src="/img/fb.png"></div>
                            <div style="clear:both"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="or" class="fl_l">&mdash; или &mdash;</div>
            <div id="signupblock" class="fl_l">
                <section id="signupbox">
                    <div id="signup-title">Регистрация</div>
                    <input type="text" id="new_name" placeholder="Отображаемое имя" class="field">
                    <input type="email" id="new_email" placeholder="Ваш email адрес" class="field">
                    <input type="password" id="new_pass" placeholder="Пароль" class="field">
                    <div id="terms"><input type="checkbox" name="terms" onclick="checkifchecked(this.checked);" checked>Согласен с <a href="/terms" target="_blank">пользовательским соглашением</a></div>
                    <div class="button" id="sign_up_send">Готово</div>
                    <div id="error"></div>
                </section>
                <section id="fadeBlock"></section>
            </div>
            <div class="clearfix"></div>
        </section>
        <div id="fb-root"></div>
        <? require 'footer.php'; ?>
        <?
            if (!isset($_SESSION['id'])) {
                echo '<script type="text/javascript" src="http://vkontakte.ru/js/api/openapi.js"></script>';
                echo '<script type="text/javascript" src="/js/vk.js"></script>';
                echo '<script type="text/javascript" src="/js/fb.js"></script>';
            }
        ?>
        <script type="text/javascript" src="/js/general.js"></script>
        <script type="text/javascript" src="/js/ajax.js"></script>
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script>
        var checkedTerms = true;

        $(document).ready(function(){
        //.setAttribute("type", "password");
    

        $("#signin").bind("click",function(){
            $.post("server/signin.php", { email: $("#email").val(), pass: $("#pass").val() }, function(data) {
                if (data=="ok") { document.location.href = "http://beoncity.com/"; }
                else {
                    if (data=="noemail") $("#emailField").css("border","1px solid red");
                    if (data=="nopass") $("#passField").css("border","1px solid red");
                    $("#loginerror").fadeIn(250); $("#loginerror").html(data); hideBlock1(); return false;
                }
                return false;
            });
        });

        $(".field input").keyup(function(){
            $("#emailField").css("border","1px solid rgba(182,182,182,.4)");
            $("#passField").css("border","1px solid rgba(182,182,182,.4)");
        });

        $("#sign_up_send").bind("click",function(){
            if (checkedTerms) {
                $("#error").fadeOut(250); $("#error").html("");
                if (($("#new_name").val()=="") || ($("#new_email").val()=="") || ($("#new_pass").val()==""))
                    { $("#error").fadeIn(250); $("#error").html("* Заполните, пожалуйста, все поля."); hideBlock();  return false; }
                if ($("#new_pass").val().lenght < 6)
                    { $("#error").fadeIn(250); $("#error").html("* Пароль должен состоять из 6 символов или более."); hideBlock(); return false; }
                if ($("#new_pass").val().lenght > 50)
                    { $("#error").fadeIn(250); $("#error").html("* Длина пароля не должна превышать 50 символов."); hideBlock(); return false; }

                $.post("server/signup.php", { name: $("#new_name").val(), regemail: $("#new_email").val(), regpasswd: $("#new_pass").val() }, function(data) {
                    if (data=="ok") {
                        alert("Спасибо за регистрацию! На Ваш адрес " + $("#new_email").val() + " было выслано сообщение с дальнейшей инструкцией (может уйти в спам). До встречи на Beoncity.");
                    }
                    else { $("#error").fadeIn(250); $("#error").html(data); hideBlock(); return false; }
                });
            }
            else {
                return false;
            }
        });

        $('#signup').bind('click',function(){
            var popuptopmargin = ($('#signupbox').height() + 10) / 2;
            var popupleftmargin = ($('#signupbox').width() + 10) / 2;
            $('#signupbox').css({
                'margin-top' : -popuptopmargin,
                'margin-left' : -popupleftmargin
            });
            $('#fadeBlock').fadeIn(250);
            $('#signupbox').fadeIn(250);
        });

        $('#fadeBlock').bind('click',function(){
            $('#fadeBlock').fadeOut(250);
            $('#signupbox').fadeOut(250);
            $("#new_name").val("");
            $("#new_surname").val("");
            $("#new_email").val("");
            $("#new_pass").val("");
            $("#error").html("");
            $("#error").fadeOut(250);
            return false;
        }); 

        function hideBlock(){ setTimeout(fo, 4000); }
        function fo(){ $('#error').fadeOut(300); }

        function hideBlock1(){ setTimeout(fo1, 4000); }
        function fo1(){ $('#loginerror').fadeOut(300); }
    });
    function checkifchecked(flag){
        checkedTerms = flag;
        if (!checkedTerms) {
            $('#sign_up_send').css('boxShadow','inset 0 1px 6px rgba(0,0,0,.15)');
            $('#sign_up_send').css('background-color','rgba(0,0,0,.15)');
            $('#sign_up_send').hover(function(){
                $('#sign_up_send').css('cursor','default');
            });
        }
        else {
            $('#sign_up_send').css('boxShadow','0 1px 6px rgba(0,0,0,.15)');
            $('#sign_up_send').css('background-color','transparent');
            $('#sign_up_send').hover(function(){
                $('#sign_up_send').css('cursor','pointer');
            });
        }
    }
        </script>
    </body>
</html>