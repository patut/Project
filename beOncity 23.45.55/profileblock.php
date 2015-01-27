<div id="mainblock">
	<div id="userheader">
		<div id="image">
			<div id="imgcover"><img src="<? echo $user['img']; ?>"/></div>
		</div>
		<div id="info">
			<div id="topline">
				<div id="usrnameblock"><?echo $user['name'];?></div>
                <div id="settings"><a href="/settings">Настройки</a></div>
			</div>
			<? 
			if (!empty($user['location'])) echo '<div id="location">'.$user['location'].'</div>';
            else echo '<div id="location"><a href="/settings">Добавить местоположение</a></div>';
			if (!empty($user['about'])) echo '<div id="about">'.$user['about'].'</div>'; 
            else echo '<div id="about"><a href="/settings">Добавить описание</a></div>';
			?>
		</div>
		<div class="clearfix"></div>
	</div>
	<div id="userwall">
		<div id="walltop">Последние события от пользователя <? echo $user['name']; ?></div>
		<div id="blockfall">
            <?
            $count = 0;
            $q = mysql_query("SELECT * FROM events WHERE author_id='$myid' ORDER BY timestamp DESC", $db);
            while ($event = mysql_fetch_array($q)) {

                $m = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
                
                if ($event['month'] == 0) $date = 'no date';
                else {
                    if ($event['hour'] < 10) $event['hour'] = '0'.$event['hour'];
                    if ($event['minute'] < 10) $event['minute'] = '0'.$event['minute'];
                    $date = $event['day'].' '.$m[$event['month']-1].', '.$event['hour'].':'.$event['minute'];//$event['year'].'&nbsp &nbsp &nbsp'.
                }

                if (empty($event['img'])) $ava = '/img/default.png';
        		else $ava = $event['img'];

                // новый пост
                $addpost = '';
                $addpost .= '<div class="post" id="post'.$event['id'].'">';
                	$addpost .= '<div onclick="toevent('.$event['id'].')" class="image fl_l"><img src="'.$ava.'"/></div>';
                    $addpost .= '<div onclick="toevent('.$event['id'].')" class="desc fl_l">';
                    	$addpost .= '<div class="title fl_l">'.$event['title'].', '.$date.'</div>';
                    	$addpost .= '<div class="total fl_l">Пойдут на событие: '.$event['willGo'].', посетили: '.$event['visited'].'</div>';
                        $addpost .= '<div class="text fl_l">'.cutString($event['desc'], 300).'</div>';
                        $addpost .= '<div class="clearfix"></div>';
                    $addpost .= '</div>';
                    $addpost .= '<div class="del fl_r"><img onclick="del(\''.$event['id'].'\')" src="/img/del.png"/></div>';
                    $addpost .= '<div class="clearfix"></div>';
                $addpost .= '</div>';
                //------------//
                echo $addpost;
                $count += 1;
            }
            if ($count==0) echo '<div id="noevents">Событий пока еще нет. <a href="/update">Создать событие?</a></div>';
        ?>

		</div>
	</div>
	<div class="clearfix"></div>
</div>
    <div id="sidebar">
        <div class="block">
            <?
            $countEvents = 0;
            $q = mysql_query("SELECT * FROM willgo WHERE userid='$myid' ORDER BY id DESC", $db);
            $addpost = '';
            while ($eventId = mysql_fetch_array($q)) {                

                $evid = $eventId['eventid'];
                $count = 0;    
                $qw = mysql_query("SELECT * FROM events WHERE id='$evid' ORDER BY timestamp DESC", $db);
                while ($event = mysql_fetch_array($qw)) {

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

                    if (empty($event['img'])) $ava = '/img/default.png';
                    else $ava = $event['img'];

                    $diff = date_diff(new DateTime(), new DateTime($date[0].'-'.$date[1].'-'.$date[2]))->days;

                    if (($diff <= 7) && ($today <= $datetime)) {
                        // новый пост
                        $addpost .= '<div class="post">';
                            $addpost .= '<div onclick="toevent('.$event['id'].')" class="image fl_l"><img src="'.$ava.'"/></div>';
                            $addpost .= '<div onclick="toevent('.$event['id'].')" class="desc fl_r">';
                                $addpost .= '<div class="title fl_l">'.$event['title'].'</div>';
                                $addpost .= '<div class="text fl_l">'.cutString($event['desc'],100).'</div>';
                                $addpost .= '<div class="clearfix"></div>';
                            $addpost .= '</div>';
                            $addpost .= '<div class="clearfix"></div>';
                        $addpost .= '</div>';
                        //------------//
                        //echo $addpost;
                        $countEvents += 1;
                    }
                    else continue;
                }
            }
            if ($countEvents==0) $addpost .= '<div id="noevents">Выбранных событий нет</div>';

            echo '<div class="title">Ближайшие выбранные ('.$countEvents.')</div>';
            echo '<div class="eventsblock">';
            echo $addpost;
            echo '</div>';
            ?>
        </div>
        <div class="block">
            <?
            $countEvents = 0;
            $q = mysql_query("SELECT * FROM beento WHERE userid='$myid' ORDER BY id DESC", $db);
            $addpost = '';
            while ($eventId = mysql_fetch_array($q)) {                

                $evid = $eventId['eventid'];
                $count = 0;    
                $qw = mysql_query("SELECT * FROM events WHERE id='$evid' ORDER BY timestamp DESC", $db);
                while ($event = mysql_fetch_array($qw)) {

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

                    if (empty($event['img'])) $ava = '/img/default.png';
                    else $ava = $event['img'];

                    $diff = date_diff(new DateTime(), new DateTime($date[0].'-'.$date[1].'-'.$date[2]))->days;

                    if (($diff <= 1) && ($diff > 0)) {
                        // новый пост
                        $addpost .= '<div class="post">';
                            $addpost .= '<div onclick="toevent('.$event['id'].')" class="image fl_l"><img src="'.$ava.'"/></div>';
                            $addpost .= '<div onclick="toevent('.$event['id'].')" class="desc fl_r">';
                                $addpost .= '<div class="title fl_l">'.$event['title'].'</div>';
                                $addpost .= '<div class="text fl_l">'.cutString($event['desc'],100).'</div>';
                                $addpost .= '<div class="clearfix"></div>';
                            $addpost .= '</div>';
                            $addpost .= '<div class="clearfix"></div>';
                        $addpost .= '</div>';
                        //------------//
                        //echo $addpost;
                        $countEvents += 1;
                    }
                    else continue;
                }
            }
            if ($countEvents==0) $addpost .= '<div id="noevents">Выбранных событий нет</div>';

            echo '<div class="title">Недавно прошедшие ('.$countEvents.')</div>';
            echo '<div class="eventsblock">';
            echo $addpost;
            echo '</div>';
            ?>
        </div>
    </div>
<div class="clearfix"></div>