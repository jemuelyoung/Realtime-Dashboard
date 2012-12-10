var io = require('socket.io').listen(4000);
var Statistics = require('./statistics.js')
var visitors = 0, load;

io.enable('browser client minification');
// send minified client
io.enable('browser client etag');
// apply etag caching logic based on version number
io.enable('browser client gzip');
// gzip the file
io.set('log level', 1);
// reduce logging
io.set('transports', [// enable all transports (optional if you want flashsocket)
'websocket', 'flashsocket', 'htmlfile', 'xhr-polling', 'jsonp-polling']);

// get new data every 1 second
setInterval(function() {
	Statistics.cpuLoad();
}, 1000);

Statistics.on('current_load', function(data) {
//	console.log(data);
	io.sockets.emit('update_load', data)

});

io.sockets.on('connection', function(socket) {
	// When a client connects, increment the visitor count and send them the number of visitors
	visitors++;
	socket.emit('init', visitors);
	// broadcast to all that a new visitor has arrived
	socket.broadcast.emit('visitorConnect', visitors);

	socket.on('disconnect', function() {
		visitors--;
		// update all clients with the new count
		socket.broadcast.emit('visitorDisconnect', visitors);
	});

});

