<?
    $pagename = 'home';
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
            <div id="filters">
                <div class="filter fl_l" id="music"><a href="?q=music" <? if ($filter == 'music') echo 'class="active"'; ?> >музыка</a></div>
                <div class="fl_r" id="deselect"><a href="/" <? if ($filter == 'allevents') echo 'class="active"'; ?> >все события</a></div>
                <div class="filter fl_l" id="dance"><a href="?q=dance" <? if ($filter == 'dance') echo 'class="active"'; ?> >танцы</a></div>
                <div class="filter fl_l" id="culture"><a href="?q=culture" <? if ($filter == 'culture') echo 'class="active"'; ?> >культура</a></div>
                <div class="filter fl_l" id="romantic"><a href="?q=romantic" <? if ($filter == 'romantic') echo 'class="active"'; ?> >романтика</a></div>
                <div class="filter fl_l" id="flashmob"><a href="?q=flashmob" <? if ($filter == 'flashmob') echo 'class="active"'; ?> >флешмобы</a></div>
                <div class="filter fl_l" id="activity"><a href="?q=activity" <? if ($filter == 'activity') echo 'class="active"'; ?> >активный отдых</a></div>
                <div class="filter fl_l" id="extreme"><a href="?q=extreme" <? if ($filter == 'extreme') echo 'class="active"'; ?> >экстрим</a></div>
                <div class="filter fl_l" id="life"><a href="?q=life" <? if ($filter == 'life') echo 'class="active"'; ?> >жизнь</a></div>
                <div class="filter fl_l" id="other"><a href="?q=other" <? if ($filter == 'other') echo 'class="active"'; ?> >разное</a></div>
            </div>
            <div id="pinwall" class="fl_l">
                <? 
                    $column = 0;
                    $firstWaterfall = '<div class="waterfall fl_l">';
                    $secondWaterfall = '<div class="waterfall fl_l">';
                    $thirdWaterfall = '<div class="waterfall fl_l">';
                    $fourthWaterfall = '<div class="waterfall fl_l">';

                    $counter = 0;
                    $q = mysql_query("SELECT * FROM events ORDER BY datetime-NOW() ASC", $db);
                    while ($event = mysql_fetch_array($q)) {
                        if ($filter != 'allevents')
                            if ($event['filter'] != $filter)
                                continue;
                        if ($event['hidden'] == '1') continue;

                        if ((int)$event['month'] < 10) $event['month'] = '0'.$event['month'];
                        if ((int)$event['day'] < 10) $event['day'] = '0'.$event['day'];
                        if ((int)$event['hour'] < 10) $event['hour'] = '0'.$event['hour'];
                        if ((int)$event['minute'] < 10) $event['minute'] = '0'.$event['minute'];


                        $date = $event['year'].'/'.$event['month'].'/'.$event['day']; 
                        $date = explode("/", $date); 
                        
                        $time = $event['hour'].'/'.$event['minute'].'/00'; 
                        $time = explode(":", $time); 
                        
                        $tz_string = "Europe/Moscow";
                        $tz_object = new DateTimeZone($tz_string); 
                        
                        $datetime = new DateTime(); 
                        $datetime->setTimezone($tz_object);
                        $datetime->setDate($date[0], $date[1], $date[2]); 
                        $datetime->setTime($time[0], $time[1], $time[2]); 


                        //$datetime->format('Y/m/d H:i:s')
                        $today = date("Y/m/d");
                        $datetime = $datetime->format('Y/m/d');

                        $diff = date_diff(new DateTime(), new DateTime($date[0].'-'.$date[1].'-'.$date[2]))->days;
                        if (($diff > 0) && ($today > $datetime)) continue; // если событие прошло день назад - еще можно

                        $opacity = '';
                        if ($today > $datetime) $opacity = 'style="opacity:.35"';

                        $m = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
                        $date = $event['day'].' '.$m[$event['month']-1].', '.$event['year'].' '.$event['hour'].':'.$event['minute'];
                        // новый пост
                        $addpost = '';
                        $addpost .= '<div '.$opacity.' class="post '.$event['filter'].'-filter">';
                            $addpost .= '<div class="title" onclick="toevent('.$event['id'].')">'.$event['title'].'</div>';
                            if(!empty($event['img'])) $addpost .= '<div class="image" onclick="toevent('.$event['id'].')"><img src="'.$event['img'].'"/></div>';
                            else $addpost .= '<div class="desc" onclick="toevent('.$event['id'].')">'.cutString($event['desc'],400).'</div>'; // в случае, если нет фотографии
                            $addpost .= '<div class="data" onclick="toevent('.$event['id'].')">';
                                $addpost .= '<div class="line">';
                                    $addpost .= '<div class="image fl_l"><img src="/img/date.png"/></div>';
                                    $addpost .= '<div class="text fl_l">'.$date.'</div>';
                                    $addpost .= '<div class="clearfix"></div>';
                                $addpost .= '</div>';
                                $addpost .= '<div class="line">';
                                    $addpost .= '<div class="image fl_l"><img src="/img/location.png"/></div>';
                                    $addpost .= '<div class="text address fl_l">'.mb_ucfirst($event['addressRU']).'</div>';// первую букву в верхний регистр, ибо иногда гугл выдает в нижнем
                                    $addpost .= '<div class="clearfix"></div>';
                                $addpost .= '</div>';
                            $addpost .= '</div>';
                            /*
                            $addpost .= '<div class="action">';
                                if(isset($_SESSION['id'])) $addpost .= '<div class="illgo" onclick="willgo('.$event['id'].',\''.$myid.'\')">Я пойду</div>';
                                if(isset($_SESSION['id'])) $addpost .= '<div class="ivebeen" onclick="havebeen('.$event['id'].',\''.$myid.'\')">Я был тут</div>';
                                if(isset($_SESSION['id'])) $addpost .= '<div class="cool" onclick="cool('.$event['id'].')">Круто</div>';
                                else $addpost .= '<div class="cool big" onclick="cool('.$event['id'].')">Круто</div>';
                                $addpost .= '<div class="clearfix"></div>';
                            $addpost .= '</div>';
                            */
                        $addpost .= '</div>';
                        //------------//

                        switch ($column) {
                            case 0:
                                $firstWaterfall .= $addpost;
                                break;
                            case 1:
                                $secondWaterfall .= $addpost;
                                break;
                            case 2:
                                $thirdWaterfall .= $addpost;
                                break;
                            case 3:
                                $fourthWaterfall .= $addpost;
                                break;
                        }

                        $column += 1;
                        $column %= 4;
                        $counter += 1;
                    }

                    $firstWaterfall .= '</div>';
                    $secondWaterfall .= '</div>';
                    $thirdWaterfall .= '</div>';
                    $fourthWaterfall .= '</div>';

                    echo $firstWaterfall.$secondWaterfall.$thirdWaterfall.$fourthWaterfall;
                    if ($counter == 0) echo '<div id="noevents"> <span>В этой категории событий нет :|</span> </div>';
                ?>
            </div>
            
            <div class="clearfix"></div>
        </section>
        <? require 'footer.php'; ?>
    </body>
</html>