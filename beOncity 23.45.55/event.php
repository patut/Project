<?
    $pagename = 'event';
    include_once 'router.php';
?>
    <body>
        <section id="header">
            <a href="/" id="logo" class="fl_l">beOncity</a>
            <?
                if ($session_id || $org_id) echo '<a href="/server/signout" id="signout" class="fl_r">Выйти</a>';
                else echo '<a href="/auth" id="registration" class="fl_r">Войти</a>';
            ?>
            <? require 'header.php'; ?>
            <div class="clearfix"></div>
        </section>
        <section id="wrap">
            <div id="cover">
                <div id="banner" style="background-image:url(<?=$cover?>)"></div>
            </div>
            <div id="content">
                <div id="topcont">
                    <?
                        if (!empty($author['id'])) {
                            $title = explode(" ~ ", $event['title']);
                            $title = '<a class="backlink" href="/org?id='.$author['id'].'">'.$author['name'].'</a> ~ '.$title[1];
                            $event['title'] = $title;
                        }
                        
                    ?>
                    <div class="title fl_l"><a class="backlink" href="/?q=music"><span><?=$filter?></a> /</span> <?=$event['title']?></div>
                    <div id="social" class="fl_r">
                        <div onclick="window.open('https://twitter.com/share?url='+encodeURIComponent(location.href),'twitter-share-dialog','width=626,height=436');" class="button fl_r"><img src="/img/icons/tw.png" title="Поделиться Twitter" alt="Поделиться Twitter"/></div>
                        <div onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href),'facebook-share-dialog','width=626,height=436');" class="button fl_r"><img src="/img/icons/fb.png" title="Поделиться Facebook" alt="Поделиться Facebook"/></div>
                        <div onclick="window.open('http://vkontakte.ru/share.php?url='+encodeURIComponent(location.href),'twitter-share-dialog','width=626,height=436');" class="button fl_r"><img src="/img/icons/vk.png" title="Поделиться Вконтакте" alt="Поделиться Вконтакте" /></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div id="container">
                    <div id="eventinfo" class="fl_l">
                        <div id="eventimg"><img src="<?=$event['img']?>"/></div>
                        <div id="people">
                            <div class="bigblock">
                                <?
                                    $countUsers = 0;
                                    $eid = $event['id'];
                                    $adduser = '';
                                    $q = mysql_query("SELECT * FROM willgo WHERE eventid='$eid' ORDER BY id DESC", $db);
                                    while (($userId = mysql_fetch_array($q)) && ($countUsers < 11)) {
                                        if ($countUsers == 10) { 
                                            $adduser .= '<div id="allusers"><a href="/people?q=going&e='.$eid.'">Все пользователи</a></div>';
                                            break;
                                        }
                                        $usId = $userId['userid'];
                                        $qw = mysql_query("SELECT * FROM users WHERE id='$usId' ORDER BY timestamp DESC", $db);
                                        while ($user = mysql_fetch_array($qw)) {
                                            // новый юзер
                                            $adduser .= '<div class="user fl_l")"><a href="/user?id='.$user['id'].'" title="'.$user['name'].'"><img src="'.$user['img'].'"/></a></div>';
                                        }
                                        $countUsers += 1;
                                    }
                                    if ($countUsers==0) $adduser .= '<div id="nousers">Пока еще никто не захотел</div>';

                                    $query = mysql_query("SELECT COUNT(*) as count FROM willgo WHERE eventid='$eid'", $db);
                                    $res = mysql_fetch_array($query);

                                    echo '<div class="title">Собираются пойти ('.$res['count'].')</div>';
                                    echo '<div class="usersblock">';
                                    echo $adduser;
                                    echo '<div class="clearfix"></div>';
                                    echo '</div>';
                                    ?>
                            </div>
                            <div class="bigblock">
                                <?
                                    $eid = $event['id'];
                                    $adduser = '';
                                    $q = mysql_query("SELECT * FROM cool WHERE eventid='$eid' ORDER BY id DESC", $db);
                                    $addpost = '';
                                    $countUsers = 0;
                                    while ($userId = mysql_fetch_array($q)) {
                                        $usId = $userId['userid'];
                                        $qw = mysql_query("SELECT * FROM users WHERE id='$usId' ORDER BY timestamp DESC", $db);
                                        while ($user = mysql_fetch_array($qw)) {
                                            if ($countUsers > 10) { 
                                                $adduser .= '<div id="allusers"><a href="/people?q=cool&e='.$eid.'">Все пользователи</a></div>';
                                                break;
                                            }
                                            // новый юзер
                                            $adduser .= '<div class="user fl_l"><a href="/user?id='.$user['id'].'"><img src="'.$user['img'].'"/></a></div>';
                                            $countUsers += 1; 
                                        }
                                    }
                                    //if ($countUsers==0) $adduser .= '<div id="nousers">Пока еще никто не захотел</div>';

                                    echo '<div class="title">Сказали "Круто!" ('.$countUsers.')</div>';
                                    echo '<div class="usersblock">';
                                    echo $adduser;
                                    echo '<div class="clearfix"></div>';
                                    echo '</div>';
                                    ?>
                            </div>
                        </div>
                    </div>
                    <div id="aboutevent" class="fl_l">
                        <div id="eventtext"><?=nl2br($event['desc'])?></div>
                        <div id="eventaction">
                            <div class="CContainer fl_l">
                                <div class="button fl_l" onclick="willgo('<?=$event['id']?>','<?=$myid?>')">
                                    <img src="/img/going.png" title="Я пойду!" class="fl_l"/>
                                    <div class="text fl_r">Я пойду!</div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="button fl_r" onclick="cool('<?=$event['id']?>','<?=$myid?>')">
                                    <img src="/img/rock.png" title="Круто!" class="fl_l"/>
                                    <div class="text fl_r">Круто!</div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <?
                            if ($session_id) { // организациям нельзя комментить
                                $q = mysql_query("SELECT * FROM users WHERE id='$myid'", $db);
                                $user = mysql_fetch_array($q);

                                if (!empty($user['id'])){
                                    echo '<div id="newcomment">';
                                    echo '<div id="userava" class="fl_l"><a href="/user?id='.$user['id'].'"><img src="'.$user['img'].'"/></a></div>';
                                    echo '<div id="commenttext" class="fl_l"><textarea type="text" onKeyDown="limitText(this,800)" onKeyUp="limitText(this,800)" id="neweventtip" maxlength="800" placeholder="Оставить комментарий..."></textarea></div>';
                                    echo '<div id="publish" class="fl_l">Отправить</div>';
                                    echo '<div id="downar"><img src="/img/triangle.png"/></div>';
                                    echo '<div class="clearfix"></div>';
                                    echo '</div>';
                                }
                            }
                        ?>
                        <div id="comments">
                        <?
                            $eid = $event['id'];
                            
                            $query = mysql_query("SELECT COUNT(*) as count FROM comments WHERE event_id='$eid'", $db);
                            $res = mysql_fetch_array($query);
                            
                            if (empty($res[0])) $info = '<div id="commentline">';
                            else {
                                $info = '<div id="commentsinfo">';
                                    if ($res[0] == 1) $info .= '<div class="fl_l" id="commN">Ответов: <span id="num">'.$res[0].'</span></div>';
                                    else $info .= '<div class="fl_l" id="commN">Ответов: <span id="num">'.$res[0].'</span></div>';
                                    $info .= '<div class="fl_r" id="commFilter">Отсортировaть по <span id="popular">популярности</span> / <span id="recent">дате</span></div>';
                                    $info .= '<div class="clearfix"></div>';
                                $info .= '</div>';

                                $info .= '<div id="commentline">';
                            }
                            
                            $comments = array();
                            $q = mysql_query("SELECT * FROM comments WHERE event_id='$eid' ORDER BY timestamp DESC LIMIT 30", $db);
                            while($comment = mysql_fetch_array($q)){
                                $comments[] = $comment;
                            }

                            for ($i = 0; $i < count($comments); $i++) {
                                $comment = $comments[$i];

                                $info .= '<div id="comm'.$comment['id'].'" class="post">';
                                    $info .= '<div class="image fl_l"><a href="/user?id='.$comment['author_id'].'"><img src="'.$comment['author_img'].'"/></a></div>';
                                    $info .= '<div class="content fl_l">';
                                        $info .= '<div class="text">'.$comment['text'].'</div>';
                                        $info .= '<div class="info"><a href="/user?id='.$comment['author_id'].'">'.$comment['author_name'].'</a></div>';
                                    $info .= '</div>';
                                    if (($session_id) && ($_SESSION['id']==$comment['author_id'])) $info .= '<div class="del fl_r"><img onclick="del(\''.$comment['id'].'\')" src="/img/del.png"/></div>';
                                    $info .= '<div class="clearfix"></div>';
                                $info .= '</div>'; 
                            }


                            $info .= '</div>';
                            echo $info;

                            if (($res[0]==0) && ($session_id)) {
                                $nocomments = '<div id="nocomments">Пока еще нет ни одного комментария - будьте первым!</div>';
                                $nocomments .= '<div id="footer">Оставьте отзыв об этом событии - что вам понравилось, что удивило, что можно было сделать лучше. Поделитесь с друзьями.</div>';
                                echo $nocomments;
                            }
                            
                        ?>
                        </div>
                    </div>
                    <div id="eventloc" class="fl_l">
                        <div id="mapcontainer">
                            <div id="map"></div>
                        </div>
                        <div id="eventdetails">
                            <div class="row">
                                <div class="catt fl_l"><img src="/img/icons/start.png"/></div>
                                <div class="value fl_l"><?=$date?></div>
                                <div class="clearfix"></div>
                            </div>
                            <!--
                            <div class="row">
                                <div class="catt fl_l"><img src="/img/icons/fin.png"/></div>
                                <div class="value fl_l">[дата конца]</div>
                                <div class="clearfix"></div>
                            </div>
                            -->
                            <div class="row">
                                <div class="catt fl_l"><img src="/img/icons/marker.png"/></div>
                                <div class="value fl_l"><?=mb_ucfirst($event['addressRU'])?></div>
                                <div class="clearfix"></div>
                            </div>
                            <?

                            if (!empty($author['phone'])) {
                                echo '<div class="row">';
                                    echo '<div class="catt fl_l"><img src="/img/icons/iphone.png"/></div>';
                                    echo '<div class="value fl_l">'.$author['phone'].'</div>';
                                    echo '<div class="clearfix"></div>';
                                echo '</div>';
                            }
                            if (!empty($author['web'])) {
                                echo '<div class="row">';
                                    echo '<div class="catt fl_l"><img src="/img/icons/web.png"/></div>';
                                    echo '<div class="value fl_l">'.$author['web'].'</div>';
                                    echo '<div class="clearfix"></div>';
                                echo '</div>';
                            }

                            ?><!--
                            <div class="row">
                                <div class="catt fl_l"><img src="/img/icons/metro.png"/></div>
                                <div class="value fl_l">Арбатская</div>
                                <div class="clearfix"></div>
                            </div>
                            -->
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </section>
        <? require 'footer.php'; ?>
        <script>
        var usrid = '<?=$myid?>';
        var usrimg = "<?=$user['img']?>";
        var usrname = "<?=$user['name']?>";
        var evntid = <?=$event['id']?>;
        var evntlat = <?=$event['latitude']?>;
        var evntlon = <?=$event['longitude']?>;

        var myLatlng = new google.maps.LatLng(<?=$event['latitude']?>,<?=$event['longitude']?>);
        var myOptions = {
            zoom: 14,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            streetViewControl: false,
            mapTypeControl: false
        }
        map = new google.maps.Map(document.getElementById("map"), myOptions);
        MYmarker = new google.maps.Marker({
            position: myLatlng,
            map: map
        });
        var pinIcon = new google.maps.MarkerImage(
            '../img/pins/current.png',
            null, /* size is determined at runtime */
            null, /* origin is 0,0 */
            null, /* anchor is bottom center of the scaled image */
            new google.maps.Size(48, 56)
        ); 
        MYmarker.setIcon(pinIcon);
        map.setCenter(MYmarker.position)
        </script>
    </body>
</html>