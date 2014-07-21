<?php
	
	// Datenbankverbindung aufbauen
	$db = new PDO('mysql:host=localhost; dbname=webapp','root','',array('charset'=>'utf8'));
	 
	// Daten eintragen in Datenbank
	$jsonArr = json_decode($_POST['termine'],true);
	
	// UTF8 URL encode
	function utf8_urldecode($str) {
	    $str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
	    return html_entity_decode($str,null,'UTF-8');
  	}
	
	for($i = 0; $i < count($jsonArr); $i++){	
		$rows = $db->exec("INSERT INTO termine(userid,timestamp,uhrzeitvon,uhrzeitbis,eintrag) VALUES ('".$jsonArr[$i]['userid']."','".$jsonArr[$i]['timestamp']."','".$jsonArr[$i]['uhrzeitvon']."','".$jsonArr[$i]['uhrzeitbis']."','".utf8_urldecode($jsonArr[$i]['eintrag'])."')");
		if($rows > 0){ echo true; }
	}

?>