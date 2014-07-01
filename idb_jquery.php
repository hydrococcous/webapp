<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>idb_jquery</title>
		<meta name="description" content="">
		<meta name="author" content="birke">
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	</head>

	<body>
		
		<style>
			LABEL{
				display:block;
			}
			
			INPUT, TEXTAREA{
				width:150px;
			}
		</style>
		
		<div id="input">
			
			<label>Datum:</label>
			<input type="date" id="datum" />
			
			<label>Eintrag:</label>
			<textarea rows="5" id="eintrag"></textarea>
			
			<hr />
			
			<button id="speichern">lokal speichern</button>
			<button id="synchronisieren">synchronisieren</button>
		</div>
		
		<script type="text/javascript">
			
			$(document).ready(function(){
				
				// variablen definieren
				// ggf. sollte mittels Modernizr geprüft werden
				// ob indexedDB unterstützt wird. (polyfill für Safari-Mobil)
				var indexedDB = window.indexedDB || window.webkitIndexedDB || window.mozIndexedDB || window.msIndexedDB;
		        var IDBTransaction = window.IDBTransaction || window.webkitIDBTransaction;
		        var db;
		        var termineDB = "Terminkalender";
		        var objectStoreName = "termine";
		        var versionDB = 1;
		        var datum;
		        var eintrag;
		        var transactionDB;
		        var objectStore;
		        var request;
		        var termineData = [];
		        
		        // Datenbank initialisieren/öffnen
		        function initialisiereDB(){
		        	request = indexedDB.open(termineDB, versionDB);  
	                request.onsuccess = function (evt) {
	                    db = request.result;                                                            
	                };
	 
	                request.onerror = function (evt) {
	                    console.log("IndexedDB Fehler: " + evt.target.errorCode);
	                };
	 
	                request.onupgradeneeded = function (evt) {                   
	                    var objectStore = evt.currentTarget.result.createObjectStore(
	                             objectStoreName, { keyPath: "id", autoIncrement: true });
	 
	                    objectStore.createIndex("datum", "datum", { unique: false });
	                    objectStore.createIndex("eintrag", "eintrag", { unique: false });
	                };
		        }
				
				initialisiereDB();
				
				// Datenbank löschen
				
				// Neuen Eintrag lokal speichern
				$('#speichern').on('click', function(){
					
					datum = $('#datum').val();
					eintrag = $('#eintrag').val();
					
					transactionDB = db.transaction(objectStoreName, "readwrite");
                    objectStore = transactionDB.objectStore(objectStoreName);                    
                    request = objectStore.add({ datum: datum, eintrag: eintrag });
                    request.onsuccess = function (evt) {
                        // do something after the add succeeded
                        console.log(evt);
                    };
                    
				});
				
				
				// lokale Einträge synchronisieren
				$('#synchronisieren').on('click', function(){
					termineData = [];
					transactionDB = db.transaction(objectStoreName, "readwrite");
					objectStore = transactionDB.objectStore(objectStoreName); 
					request = objectStore.openCursor();
					request.onsuccess = function(evt){
						var cursor = evt.target.result;
						if(cursor){
							//console.log(cursor.key + ' - ' + cursor.value.eintrag)
							termineData.push({
								datum: cursor.value.datum,
								eintrag: cursor.value.eintrag
							});
							
							cursor.continue();
						} else {
							//console.log('<-- ENDE');
							//alert(termineData);
							writeToDB(termineData);
						}
					}
					
					
				});
				
				
				// Daten per AJAX in Datenbank schreiben
				function writeToDB(jsonObj){
					$.ajax({
						type: 'POST',
						url: 'idbToMySQL.php',
						data: {termine: JSON.stringify(jsonObj)},
						dataType: 'json',
						async: true,
						success: function(data){
							console.log(data);
						},
						error: function(xhr, status, errorThrown){
							console.log(status);
							console.log(errorThrown);
						}
					});
				}
				
				
			});
			
		</script>
		
	</body>
</html>
