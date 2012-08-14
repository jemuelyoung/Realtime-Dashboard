var io = require('socket.io').listen(4000);
var events = require('events');
var util = require('util');
var exec = require('child_process').exec;
var visitors, load;

function Statistics() {
	if (false === (this instanceof Statistics)) {
		return new Statistics();
	}
	events.EventEmitter.call(this);
}

util.inherits(Statistics, events.EventEmitter);

Statistics.prototype.cpuLoad = function() {
	var self = this, load;
	exec("top -b -n2 -d 00.20 |grep \"load average\"|tail -1 | awk -F \",\" '{ print $4,$5, $6 }'", function(error, stdout, stderr) {
		//console.log('stdout: ' + stdout);
		self.emit('current_load', stdout);
		if (error !== null) {
			console.log('exec error: ' + error);
		}
	});

};

var stats = new Statistics();

setInterval(function() {
	stats.cpuLoad();

}, 1000);

stats.on('current_load', function(data) {
	console.log(data);
	io.sockets.emit('update_load', data)

});

io.sockets.on('connection', function(socket) {
	// When a client connects, send them the number of visitors
	visitors = io.sockets.clients().length.toString();
	socket.emit('init', visitors);

	// when a new visitor arrives
	socket.on('visitorConnect', function() {
		visitors = io.sockets.clients().length.toString();
		console.log('visitors: ' + visitors);
		// update all clients with the new count
		socket.broadcast.emit('visitorConnect', visitors);
	});

	socket.on('disconnect', function() {
		visitors = io.sockets.clients().length - 1;
		// update all clients with the new count
		socket.broadcast.emit('visitorDisconnect', visitors);
	});

});

