<?
	/* 
		Этот файл будет добавляться на каждой странице после определения переменной $page.
		Можно сказать, что это как конфигурационный файл для каждойиз страниц.
		Здесь будут автоматичеки генерироваться все нужные переменные.
		Собрано все в одном месте для удобства в дальнейшей работе с сайтом.
	*/

	include_once 'functions.php';
	include_once 'server/db.php';
    mysql_query("SET NAMES utf8");

	session_start();
	// переменная для проверки наличия сессии
    $session_id = isset($_SESSION['id']);

    // id юзера, просматривающего сайт
    if ($session_id) $myid = $_SESSION['id'];
    else $myid = 'notauth';

    // опции и настройки для каждой страницы
    switch($pagename) {
    	// открыта страница "На горячее"
    	case 'home': {
    		// файлы
    		$css = array(
                '/css/main.css',
                '/css/home.css',
                'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'
            );
            $js = array(
            	'/js/general.js',
            	'/js/jquery.min.js',
                'http://code.jquery.com/ui/1.10.3/jquery-ui.js',
                '/js/ajax.js',
                '/js/jquery.ddslick.min.js',
                '/js/jquery-ui-timepicker-addon.js',
                '/js/home.js'
            );
            $page = array(
                'title' 			=> 'beOncity • на горячее',
                'meta_description'	=> 'Beoncity - это платформа для поиска и создания различного рода событий. Здесь вы найдете информацию о разных мероприятиях, встречах, флеш-мобах, экскурсиях и выставках, не освещаемых крупными досуговыми ресурсами, как afisha.ru или kudago.ru. Куда можно пойти с ребёнком, девушкой, друзьями. Сами пользователи рассказывают, куда пойти, создают анонсы, рассказывая другим о происходящих событиях или интересных местах.',
                'meta_keywords'		=> 'События, время, прогулки, флешмобы, танцы, музыка, фестивали, топ, где, куда, что, куда пойти, что делать, где есть, культура, экстрим, спорт, активный отдых',
                'css'   			=> $css,
                'js'   				=> $js
            );
			// изначально открыты все события
			$filter = 'allevents';
			// массив со всеми категориями
			$filters = array('music','dance','culture','activity','romantic','flashmob','extreme','life','other');
			// если подан GET-параметр 'q'
		    if (isset($_GET['q'])) {
		    	// q - запрос на выдачу событий опредленной категории
		        $q = $_GET['q'];
		        $q = stripslashes($q);
		        $q = htmlspecialchars($q);
		        $q = trim($q);
		        // поиск на совпадение запроса с категорией из массива // смена текущего фильтра
		        for ($i=0; $i<count($filters); $i++) if ($filters[$i] == $q) $filter = $filters[$i];
		    }

		    break;
		}
    	case 'map': {
    		$css = array(
                '/css/main.css',
                '/css/map.css'
            );
            $js = array(
            	'/js/general.js',
            	'http://maps.google.com/maps/api/js?sensor=false',
            	'/js/jquery.min.js',
                '/js/ajax.js',
                '/js/infobox.js',
                '/js/map-options.js',
                '/js/map.js'
            );
            $page = array(
                'title' 			=> 'beOncity • карта',
                'meta_description'	=> 'Beoncity - это платформа для поиска и создания различного рода событий. Здесь вы найдете информацию о разных мероприятиях, встречах, флеш-мобах, экскурсиях и выставках, не освещаемых крупными досуговыми ресурсами, как afisha.ru или kudago.ru. Куда можно пойти с ребёнком, девушкой, друзьями. Сами пользователи рассказывают, куда пойти, создают анонсы, рассказывая другим о происходящих событиях или интересных местах.',
                'meta_keywords'		=> 'События, время, карта, точки, прогулки, флешмобы, танцы, музыка, фестивали, топ, где, куда, что, куда пойти, что делать, где есть, культура, экстрим, спорт, активный отдых',
                'css'   			=> $css,
                'js'   				=> $js
            );
            break;
    	}
    	case 'update': {
    		$css = array(
                '/css/main.css',
                '/css/update.css',
                '/css/login.css',
                'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'
            );
            if ($session_id)
	            $js = array(
	            	'/js/general.js',
	            	'http://maps.google.com/maps/api/js?sensor=false',
	            	'/js/map-options.js',
	            	'/js/jquery.min.js',
	                '/js/ajax.js',
	                '/js/jquery.ddslick.min.js',
	                'http://code.jquery.com/ui/1.10.3/jquery-ui.js',
	                '/js/jquery-ui-timepicker-addon.js',
	                '/js/jquery.form.min.js',
	                '/js/update.js',
                    '/js/right.js'
	            );
	        else 
	        	$js = array(
	            	'/js/general.js',
	            	'/js/jquery.min.js',
	                '/js/ajax.js',
	                'http://vkontakte.ru/js/api/openapi.js',
	                '/js/vk.js',
	                '/js/fb.js',
	                '/js/login.js'
	            );
            $page = array(
                'title' 			=> 'beOncity • новое событие',
                'meta_description'	=> 'Beoncity - это платформа для поиска и создания различного рода событий. Здесь вы найдете информацию о разных мероприятиях, встречах, флеш-мобах, экскурсиях и выставках, не освещаемых крупными досуговыми ресурсами, как afisha.ru или kudago.ru. Куда можно пойти с ребёнком, девушкой, друзьями. Сами пользователи рассказывают, куда пойти, создают анонсы, рассказывая другим о происходящих событиях или интересных местах.',
                'meta_keywords'		=> 'События, время, прогулки, флешмобы, танцы, музыка, фестивали, топ, где, куда, что, куда пойти, что делать, где есть, культура, экстрим, спорт, активный отдых',
                'css'   			=> $css,
                'js'   				=> $js
            );
            break;
    	}
    	case 'badbrowser': {
    		$css = array(
                '/css/main.css',
                '/css/badbrowser.css'
            );
            $js = array();
            $page = array(
                'title' 			=> 'beOncity • плохой браузер',
                'meta_description'	=> 'Beoncity - это платформа для поиска и создания различного рода событий. Здесь вы найдете информацию о разных мероприятиях, встречах, флеш-мобах, экскурсиях и выставках, не освещаемых крупными досуговыми ресурсами, как afisha.ru или kudago.ru. Куда можно пойти с ребёнком, девушкой, друзьями. Сами пользователи рассказывают, куда пойти, создают анонсы, рассказывая другим о происходящих событиях или интересных местах.',
                'meta_keywords'		=> 'События, время, прогулки, флешмобы, танцы, музыка, фестивали, топ, где, куда, что, куда пойти, что делать, где есть, культура, экстрим, спорт, активный отдых',
                'css'   			=> $css,
                'js'   				=> $js
            );
            break;
    	}
    	case 'profile': {

    		if ($session_id) {
    			$q = mysql_query("SELECT * FROM users WHERE id='$myid'", $db);
        		$user = mysql_fetch_array($q);
    		}

    		$css = array(
                '/css/main.css',
                '/css/login.css',
                '/css/profile.css'
            );

            if ($session_id)
                $js = array(
                    '/js/general.js',
                    '/js/jquery.min.js',
                    '/js/ajax.js',
                    '/js/profile.js'
                );
            else 
                $js = array(
                    '/js/general.js',
                    '/js/jquery.min.js',
                    '/js/ajax.js',
                    'http://vkontakte.ru/js/api/openapi.js',
                    '/js/vk.js',
                    '/js/fb.js',
                    '/js/login.js'
                );
            if ($session_id)
	            $page = array(
	                'title' 			=> 'beOncity • '.$user['name'],
	                'meta_description'	=> 'Beoncity - это платформа для поиска и создания различного рода событий. Здесь вы найдете информацию о разных мероприятиях, встречах, флеш-мобах, экскурсиях и выставках, не освещаемых крупными досуговыми ресурсами, как afisha.ru или kudago.ru. Куда можно пойти с ребёнком, девушкой, друзьями. Сами пользователи рассказывают, куда пойти, создают анонсы, рассказывая другим о происходящих событиях или интересных местах.',
	                'meta_keywords'		=> 'События, время, прогулки, флешмобы, танцы, музыка, фестивали, топ, где, куда, что, куда пойти, что делать, где есть, культура, экстрим, спорт, активный отдых',
	                'css'   			=> $css,
	                'js'   				=> $js
	            );
	        else 
	        	$page = array(
	                'title' 			=> 'beOncity • профиль',
	                'meta_description'	=> 'Beoncity - это платформа для поиска и создания различного рода событий. Здесь вы найдете информацию о разных мероприятиях, встречах, флеш-мобах, экскурсиях и выставках, не освещаемых крупными досуговыми ресурсами, как afisha.ru или kudago.ru. Куда можно пойти с ребёнком, девушкой, друзьями. Сами пользователи рассказывают, куда пойти, создают анонсы, рассказывая другим о происходящих событиях или интересных местах.',
	                'meta_keywords'		=> 'События, время, прогулки, флешмобы, танцы, музыка, фестивали, топ, где, куда, что, куда пойти, что делать, где есть, культура, экстрим, спорт, активный отдых',
	                'css'   			=> $css,
	                'js'   				=> $js
	            );
            break;
    	}
        case 'user': {
            
            if(isset($_GET['id'])) {
                $showid = $_GET['id'];
                $showid = stripslashes($showid);
                $showid = htmlspecialchars($showid);
                $showid = trim($showid);

                $q = mysql_query("SELECT * FROM users WHERE id='$showid'", $db);
                $user = mysql_fetch_array($q);
                if (empty($user['id'])) header("location: /"); // показывать , что юзера нет -> сверстать блок

                //if (empty($user['img'])) { $ava = '/img/default.png'; }
                //else { $ava = $user['img']; }
            }
            else header("location: /");

            $css = array(
                '/css/main.css',
                '/css/login.css',
                '/css/profile.css'
            );
            if ($session_id)
                $js = array(
                    '/js/general.js',
                    '/js/jquery.min.js',
                    '/js/ajax.js',
                    '/js/profile.js'
                );
            else 
                $js = array(
                    '/js/general.js',
                    '/js/jquery.min.js',
                    '/js/ajax.js',
                    'http://vkontakte.ru/js/api/openapi.js',
                    '/js/vk.js',
                    '/js/fb.js',
                    '/js/login.js'
                );
            if ($session_id)
                $page = array(
                    'title'             => 'beOncity • '.$user['name'],
                    'meta_description'  => 'Beoncity - это платформа для поиска и создания различного рода событий. Здесь вы найдете информацию о разных мероприятиях, встречах, флеш-мобах, экскурсиях и выставках, не освещаемых крупными досуговыми ресурсами, как afisha.ru или kudago.ru. Куда можно пойти с ребёнком, девушкой, друзьями. Сами пользователи рассказывают, куда пойти, создают анонсы, рассказывая другим о происходящих событиях или интересных местах.',
                    'meta_keywords'     => 'События, время, прогулки, флешмобы, танцы, музыка, фестивали, топ, где, куда, что, куда пойти, что делать, где есть, культура, экстрим, спорт, активный отдых',
                    'css'               => $css,
                    'js'                => $js
                );
            else 
                $page = array(
                    'title'             => 'beOncity • профиль',
                    'meta_description'  => 'Beoncity - это платформа для поиска и создания различного рода событий. Здесь вы найдете информацию о разных мероприятиях, встречах, флеш-мобах, экскурсиях и выставках, не освещаемых крупными досуговыми ресурсами, как afisha.ru или kudago.ru. Куда можно пойти с ребёнком, девушкой, друзьями. Сами пользователи рассказывают, куда пойти, создают анонсы, рассказывая другим о происходящих событиях или интересных местах.',
                    'meta_keywords'     => 'События, время, прогулки, флешмобы, танцы, музыка, фестивали, топ, где, куда, что, куда пойти, что делать, где есть, культура, экстрим, спорт, активный отдых',
                    'css'               => $css,
                    'js'                => $js
                );
            break;
        }
        case 'event': {
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                $id = stripslashes($id);
                $id = htmlspecialchars($id);
                $id = trim($id);

                $q = mysql_query("SELECT * FROM events WHERE id='$id'", $db);
                $event = mysql_fetch_array($q);
                if (empty($event['id'])) header("location: /");

                if (empty($event['img'])) { $cover = '/img/cover.png'; $ava = '/img/default.png'; }
                else { $cover = $event['img']; $ava = $event['img']; }

                $m = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');

                if ($event['month'] == 0) $date = 'no date';
                else {
                    if ($event['hour'] < 10) $event['hour'] = '0'.$event['hour'];
                    if ($event['minute'] < 10) $event['minute'] = '0'.$event['minute'];
                    $date = $event['day'].' '.$m[$event['month']-1].', '.$event['hour'].':'.$event['minute'];//$event['year'].'&nbsp &nbsp &nbsp'.
                }

                $event['desc'] = str_replace('"', '', $event['desc']);

                $desc = $event['desc'];
                $notfor = array(',','\'','"','/','\\','~','?','@','#','№','$','^','&','*','(',')','-','_','+','=',':','|','`','!');
                $desc = str_replace($notfor, '', $desc);
                $desc = str_replace(' ', ',', $desc);
            }
            else header("location: /");

            $css = array(
                '/css/main.css',
                '/css/event.css'
            );
            $js = array(
                'http://maps.google.com/maps/api/js?sensor=false',
                '/js/map-options.js',
                '/js/general.js',
                '/js/ajax.js',
                '/js/jquery.min.js',
                '/js/event.js'
            );
            $page = array(
                'title'             => 'beOncity • '.$event['title'],
                'meta_description'  => $event['desc'],
                'meta_keywords'     => $desc,
                'css'               => $css,
                'js'                => $js
            );
            break;
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
    	<title><?=$page['title']?></title>
        <meta name="viewport" content="width=1200" />
        <meta charset="utf-8" />
        <meta name="application-name" content="Beoncity" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="description" content="<?=$page['meta_description']?>" />
        <meta name="keywords" content="<?=$page['meta_keywords']?>" />

        <meta property="og:type" content="website" />
        <meta property="og:description" content="<?=$page['meta_description']?>" />
        <meta property="og:determiner" content="the" />
        <meta property="og:locale" content="ru_RU" />
        <meta property="og:locale:alternate" content="en_US" />
        <meta property="og:locale:alternate" content="en_GB" />
        <meta property="og:site_name" content="Beoncity" />


        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@beoncity">
        <meta name="twitter:title" content="<?=$page['title']?>">
        <meta name="twitter:description" content="<?=$page['meta_description']?>">
        <meta name="twitter:creator" content="@beoncity">
        <meta name="twitter:url" content="http://beoncity.com<?=$_SERVER['REQUEST_URI']?>" />


        <?
        	for ($i = 0; $i < count($page['css']); $i++) echo '<link rel="stylesheet" href="'.$page['css'][$i].'" />';
        ?>
        <?php include_once("analyticstracking.php") ?>
    </head>