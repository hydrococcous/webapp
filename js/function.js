$(document).ready(function(){
	
	var socket;
	
	function connectToServer(){
		// Websocket
		socket = new WebSocket("ws://192.168.2.105:8000");
	 
		// Nach dem öffnen des Sockets den Status anzeigen
		socket.onopen 	= function(){ 
			//message('Socket Status: '+socket.readyState+' (open)');
			};
			
		// Nach dem empfangen einer Nachricht soll diese angezeigt werden
		socket.onmessage= function(msg){
			message(msg.data);
			};			
		}
		
	// SENDEN
	function send(val){
		var ctrl = val;
		socket.send(ctrl);
		message('Gesendet : '+ctrl);
		}
 
	// Funktion welche die Nachrichten an das Log anfügt
	function message(msg){
		console.log(msg);
		
		switch(msg){
			case "next":
			impress().next();
			break;
			
			case "prev":
			impress().prev();
			break;
		}
		
		}
	
	var thisVal;
	
	$('#next').click(function(){
		thisVal = $(this).val();
		send(thisVal);
	});
	
	$('#prev').click(function(){
		thisVal = $(this).val();
		send(thisVal);
	});
	
	$('#connect').click(function(){
		connectToServer();
	});
 	
 	
 	
 	
		
});