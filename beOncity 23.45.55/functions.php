<?
// функция для ограничения размера строки по заданному числовому значению
function cutString($string, $maxlen) {
    $len = (mb_strlen($string) > $maxlen)
        ? mb_strripos(mb_substr($string, 0, $maxlen), ' ')
        : $maxlen
    ;
    $cutStr = mb_substr($string, 0, $len);
    return (mb_strlen($string) > $maxlen)
        ? '' . $cutStr . '...'
        : '' . $cutStr . ''
    ;
}

// функция для перевода первой буквы первого слова строки из нижнего регистра в верхний
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
?>