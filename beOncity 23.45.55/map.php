<?
    $pagename = 'map';
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
            <div id="global">
                <div id="mapcontainer" class="fl_l">
                    <div id="map"></div>
                </div>
                <div id="events" class="fl_r">
                    <div class="header">
                        <div class="title fl_l">Топ 50 ближайших</div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </section>
        <? require 'footer.php'; ?>
        <script><?echo 'var usr = "'.$myid.'";'; ?></script>
    </body>
</html>