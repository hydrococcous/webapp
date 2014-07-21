<?php
	
	// Datenbankverbindung aufbauen
	$db = new PDO('mysql:host=localhost; dbname=webapp','root','',array('charset'=>'utf8'));
	
	$termine = array();
	
	$anfrage = $db->query('SELECT * FROM termine');
	while($ausgabe = $anfrage->fetch(PDO::FETCH_ASSOC)){
		$termine[] = array('timestamp'=>utf8_encode($ausgabe['timestamp']), 
						   'uhrzeitvon'=>utf8_encode($ausgabe['uhrzeitvon']),
						   'uhrzeitbis'=>utf8_encode($ausgabe['uhrzeitbis']),
						   'userid'=>utf8_encode($ausgabe['userid']),
						   'eintrag'=>utf8_encode($ausgabe['eintrag'])
						   ); 
	}
	
	$resp['termine'] = $termine;
	
	echo json_encode($resp);

?>