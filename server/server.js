//===============================================
// Websocket Server 0.2
//===============================================

// verbundene Clients
var ClientListe = {};

// Anzahl verbundener Clients
var ClientAnzahl = 0;

// Websocket Server
var WebSocketServer = require('ws').Server;
var wss = new WebSocketServer({host: '192.168.2.153', port: 8000});

wss.on('connection', function(ws){
	
	// Clientanzahl hochzählen
	ClientAnzahl++;
	
	// Client-verbindung in die Liste aufnehmen
	ws['AUTH'] = ClientAnzahl;
	ClientListe[ws['AUTH']] = ws;
	
	console.log('Client ' + ClientAnzahl + ' verbunden...');
	
	ws.on('message', function(message){
		console.log('von Client empfangen: ' + message);
		for(client in ClientListe){
			ClientListe[client].send(message);
		}
		
	ws.on('close', function(){
		delete ClientListe[ws['AUTH']];
		
		console.log('Client ' + ws['AUTH'] + ' getrennt.');
		});
	
	});
	
});
