<?
	require 'db.php';
	mysql_query("SET NAMES utf8");

	// функция для конвертации первым букв слов строки в заглавные (либо только у первого слова строки)
    // конкретно для unicode, ибо для него ucwords() и ucfirst() не пашет
    if (!function_exists('mb_ucfirst') && extension_loaded('mbstring')) {
        /**
         * использование - mb_ucfirst($str) 
         * mb_ucfirst - преобразует первый символ в верхний регистр
         * @param string $str - строка
         * @param string $encoding - кодировка, по-умолчанию UTF-8
         * @return string
         */
        function mb_ucfirst($str, $encoding='UTF-8')
        {
            $str = mb_ereg_replace('^[\ ]+', '', $str);
            $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
                   mb_substr($str, 1, mb_strlen($str), $encoding);
            return $str;
        }
    }
    function cutString($string, $maxlen) {
	    $len = (mb_strlen($string) > $maxlen)
	        ? mb_strripos(mb_substr($string, 0, $maxlen), ' ')
	        : $maxlen
	    ;
	    $cutStr = mb_substr($string, 0, $len);
	    return (mb_strlen($string) > $maxlen)
	        ? '"' . $cutStr . '..."'
	        : '"' . $cutStr . '"'
	    ;
	}
	
	$maxlen = 120;
	$massiv = array();
	$result = mysql_query("SELECT * FROM  events ORDER BY datetime-NOW() ASC", $db);
	while ($event = mysql_fetch_array($result)) {

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
        
		$today = date("Y/m/d");
        $datetime = $datetime->format('Y/m/d');

		$date = $event['year'].'/'.$event['month'].'/'.$event['day']; 
        $date = explode("/", $date); 
		$diff = date_diff(new DateTime(), new DateTime($date[0].'-'.$date[1].'-'.$date[2]))->days;
		if ($today <= $datetime) { //(($diff <= 90) && ) {

			if (empty($event['img'])) $event['img'] = '/img/default.png';
			$massiv[] = array(
			'id'		=>	$event['id'],
			'latitude'	=>	$event['latitude'],
			'longitude'	=>	$event['longitude'],
			'title'		=>	mb_ucfirst($event['title']),
			'desc'		=>	cutString($event['desc'], $maxlen),
			'loc_ru'	=>	mb_ucfirst($event['addressRU']),
			'loc_en'	=>	mb_ucfirst($event['addressEN']),
			'img'		=>	$event['img'],
			'filter'	=>	mb_ucfirst($event['filter']),
			'author_id'	=>	$event['author_id']
			);
		}
		else continue;
	}
	$data = array(
		"data" => $massiv
	);
	echo json_encode($data);
