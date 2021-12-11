<?php
// Datenbank connection
require_once('../config/database.php');


if( defined('DB_HOST') && defined('DB_USERNAME') && defined('DB_PASSWORD') && defined('DB_DATABASE') ){
	$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	
	if ($conn == false){
		$dbgmsg = '';
		if(SQLDEBUG == true){
			$dbgmsg = 'MySQL server meldet: '.mysqli_connect_error();
		}
		die('DB verbindung hat nicht geklappt. '.$dbgmsg);
	}
}else{
	die('Konfigurationsdatei nicht gefunden oder keine Anmeldedaten vorhanden'); 
}

// Session lifetime
define('SESSION_LIFETIME', 180); // session dauer in minutes, 180 minutes (3 hours)
?>
