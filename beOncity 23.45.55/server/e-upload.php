<?

/* OUTPUT: 
 - 'wrongext'		: неправильное расширение файла 
 - 'notvalid'		: некорректные данные
 - 'mysql_error()'	: ошибка при работе с MySQL
*/

if($_FILES['userfile']['size'] > 0) {
	if($_FILES['userfile']['size'] < 1024000*10) {//10 mb
		// Проверяем пришел ли файл
		if( !empty( $_FILES['userfile']['name'] ) ) {
			// Проверяем, что при загрузке не произошло ошибок
			if ( $_FILES['userfile']['error'] == 0 ) {
				// Если файл загружен успешно, то проверяем - графический ли он
				if( substr($_FILES['userfile']['type'], 0, 5)=='image' ) {
					// Читаем содержимое файла
					$fileName = $_FILES['userfile']['name'];
					$tmpName  = $_FILES['userfile']['tmp_name'];
					$fileSize = $_FILES['userfile']['size'];
					$fileType = $_FILES['userfile']['type'];

					$allowed_ext = array('jpg','jpeg','png');

					$filenameext = explode(".", $fileName);
					$ext = end($filenameext);
					$fileName = $filenameext[0].$_FILES['userfile']['size'].'.'.$ext;

					if( in_array($ext, $allowed_ext) ) {
						move_uploaded_file($tmpName,'../uploads/'.$fileName);
						echo '$$$'.$fileName; // $$$ - приставка, чтобы распознать, ошибку скрипт выдает клиенту, или имя файла
					}
					else die('...wrongext'); // многоточие для того, чтобы распознать, что сервер выдал клиенту ошибку
				}
			}
			else die('...'.$_FILES['userfile']['error']); // многоточие для того, чтобы распознать, что сервер выдал клиенту ошибку
		}
		else die('...empty filename'); // многоточие для того, чтобы распознать, что сервер выдал клиенту ошибку
	}
	else die('...File size is over 10MB.'); // многоточие для того, чтобы распознать, что сервер выдал клиенту ошибку
}
else die('...'.$_FILES['userfile']['size']); // многоточие для того, чтобы распознать, что сервер выдал клиенту ошибку
