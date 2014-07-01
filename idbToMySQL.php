<?php

	// Datanbankverbindung aufbauen
	$db = new mysqli('localhost', 'root', '', 'termine');
	if(mysqli_connect_errno()){
		die('Konnte keine Verbindung zur Datenbak aufbauen: '.mysqli_connect_errno());
	}
	
	// Datenbak auslesen
	/*
	$sql = 'SELECT * FROM termine';
	$result = $db->query($sql);
	
	while($row = $result->fetch_assoc()){
		echo $row['datum'];
		echo $row['eintrag'];
	}
	*/
	 
	 
	// Daten eintragen in Datenbank
	$json = $_POST['termine'];
	print_r(json_decode($json, true));
	
?>