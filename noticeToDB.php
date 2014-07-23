<?php
	
	// Datenbankverbindung aufbauen
	$db = new PDO('mysql:host=localhost; dbname=webapp','root','',array('charset'=>'utf8'));

	// UTF8 URL encode
	function utf8_urldecode($str) {
	    $str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
	    return html_entity_decode($str,null,'UTF-8');
  	}
	
	$arr = array();
	$arr[0] = 'foobar';
	
	// Daten in die DB schreiben
	if($_POST){
	
		// JSON-Daten decodieren
		$jsonArr = json_decode($_POST['notice'],true);
	
		for($i = 0; $i < count($jsonArr); $i++){	
			$rows = $db->exec("INSERT INTO notice(title,notice) VALUES ('".$jsonArr[$i]['title']."','".utf8_urldecode($jsonArr[$i]['notice'])."')");
			if($rows > 0){ echo json_encode($arr[0]); }
			}
		} else {
		
		// Daten aus DB auslesen
		$notice = array();
		
		$anfrage = $db->query('SELECT * FROM notice'); 
		while($ausgabe = $anfrage->fetch(PDO::FETCH_ASSOC)){
			$notice[] = array('title'=>utf8_encode($ausgabe['title']), 'notice'=>utf8_encode($ausgabe['notice']));
			}
		
		$noticeJSON['notice'] = $notice;
		echo json_encode($noticeJSON);
		
		}

?>