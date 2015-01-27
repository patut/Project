<?
    $pagename = 'update';
    include_once 'router.php';
?>
    <body>
        <section id="header">
            <a href="/" id="logo" class="fl_l">beOncity</a>
            <?
                if (isset($_SESSION['id'])) echo '<a href="/server/signout" id="signout" class="fl_r">Выйти</a>';
                else echo '<a href="/register" id="registration" class="fl_r">Войти</a>';
            ?>
            <? require 'header.php'; ?>
            <div class="clearfix"></div>
        </section>
        <section id="wrap">
            <?
                if (isset($_SESSION['id'])) require_once 'updateblock.php';
                else require_once 'loginform.php';
            ?>
            <div class="clearfix"></div>
        </section>
        <div id="userid" style="display:none"><? echo $myid; ?></div>
        <div id="coords"></div>
        <div id="fb-root"></div>
        <? require 'footer.php'; ?>
        
    </body>
</html>