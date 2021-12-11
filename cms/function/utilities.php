<?php 
/* === DISINFECTION USER INPUTS === */

function desinfect($str) {
	$str = trim($str); // removes whitespace
	$str = filter_var($str, FILTER_SANITIZE_STRING); // desinfect strings, removes tags and remove or encode special characters from a string
	$str = strip_tags($str); // removes HTML and PHP tags from a string
	$str = htmlspecialchars($str); // convert special characters to HTML entities
	return $str;
}

// "decode" disinfection function above, otherwise some html tags for example won't work for formatting with CKEditor
function decodeStr($str) {
	$str = html_entity_decode($str);
	$str = htmlspecialchars_decode($str);
	return $str;
}
/* === SESSION === */

function sessionIsValid() {
	$sessionIsValid = false; 
	$sessionExists = (isset($_SESSION['isLoggedin']) && $_SESSION['isLoggedin'] == true);

	if($sessionExists){
		$now = time();
		$lastActivity = $now - $_SESSION['timestamp'];
		
		$sessionDuration = SESSION_LIFETIME*60; // 180 minutes (3 hours)
	
		$sessionIsValid = ( 
			$lastActivity < $sessionDuration && 
			$_SESSION['userip'] == $_SERVER['REMOTE_ADDR'] && 
			$_SESSION['useragent'] == $_SERVER['HTTP_USER_AGENT']
		);
		
	}	
	return $sessionIsValid; // return true or false
}


