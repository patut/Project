<section id="globalFooter">
    <div class="block fl_l">
        <div class="title">Настройки языка</div>
        <div class="content">
            <div class="item"><a href="http://beoncity.com/">English</a></div>
            <div class="item"><a href="http://beoncity.com/">Русский</a></div>
        </div>
    </div>
    <div class="block fl_l">
        <div class="title">Интересное</div>
        <div class="content">
            <div class="item"><a href="#">Новости и предложения</a></div>
            <div class="item"><a href="#">Мобильное приложение</a></div>
            <div class="item"><a href="#">Как все работает</a></div>
        </div>
    </div>
    <div class="block fl_l">
        <div class="title">Компания</div>
        <div class="content">
            <div class="item"><a href="#">О проекте</a></div>
            <div class="item"><a href="#">Блог</a></div>
            <div class="item"><a href="#">Помощь</a></div>
            <div class="item"><a href="#">Правила использования</a></div>
        </div>
    </div>
    <div class="block fl_l">
        <div class="title">Присоединяйтесь к нам</div>
        <div class="content">
            <div class="item"><a href="http://twitter.com/beoncity">Twitter</a></div>
            <div class="item"><a href="https://www.facebook.com/beoncity">Facebook</a></div>
            <div class="item"><a href="http://vk.com/beoncity">Vk.com</a></div>
            <div class="item"><a href="/">&copy beOncity, Inc.</a></div>
        </div>
    </div>
    <div class="clearfix"></div>
</section>
<?
    for ($i = 0; $i < count($page['js']); $i++) echo '<script type="text/javascript" src="'.$page['js'][$i].'"></script>';
    if (!$session_id && ($pagename == 'profile' || $pagename == 'update')) {
        include_once 'signupblock.php';
    }
?>
