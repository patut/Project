<?	
	session_start();
    
	if (isset($_POST['closed'])) {
		$_SESSION['seenabout'] = 'seenabout';
		echo 'ok';
	} else exit();