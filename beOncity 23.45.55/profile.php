<? 
    $pagename = 'profile';
    include_once 'router.php';
?>
    <body>
        <section id="header">
            <a href="/" id="logo" class="fl_l">beOncity</a>
            <?
                if ($session_id) echo '<a href="/server/signout" id="signout" class="fl_r">Выйти</a>';
                else echo '<a href="/register" id="registration" class="fl_r">Войти</a>';
            ?>
            <? require 'header.php'; ?>
            <div class="clearfix"></div>
        </section>
        <section id="wrap">
            <?
                if ($session_id) include_once 'profileblock.php';
                else include_once 'loginform.php';
            ?>
            <div class="clearfix"></div>
        </section>
        <div id="fb-root"></div>
        <? require 'footer.php'; ?>
    </body>
</html>

