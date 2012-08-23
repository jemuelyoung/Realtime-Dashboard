var io = require('socket.io').listen(4000);
var events = require('events');
var util = require('util');
var exec = require('child_process').exec;
var visitors = 0, load, numProcessors;

// get the number of processors
exec("grep 'model name' /proc/cpuinfo | wc -l", function(error, stdout, stderr) {
	numProcessors = parseInt(stdout);
	if (error !== null) {
		console.log('exec error: ' + error);
	}
});

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

function Statistics() {
	if (false === (this instanceof Statistics)) {
		return new Statistics();
	}
	events.EventEmitter.call(this);
}

util.inherits(Statistics, events.EventEmitter);

Statistics.prototype.cpuLoad = function() {
	var self = this, load;
	// checks the cpu load every 1 second 3x and averages out the cpu load
	//  print $4,$5,$6
	// {$4} : 1  average over the last minute
	// {$5} : 1  average over the 5 minutes
	// {$6} : 1  average over the 15 minutes
	exec("sar -q 1 3 |grep \"Average\"|awk -F \" \" '{ print $4,$5 }'", function(error, stdout, stderr) {
		// divide the load by the number of processors in case of multi-core system
	//	var loadAvg = stdout/numProcessors;
		//console.log('stdout: ' + stdout);
		
		self.emit('current_load', stdout);
		if (error !== null) {
			console.log('exec error: ' + error);
		}
	});

};

var stats = new Statistics();
// get new data every 3 seconds
setInterval(function() {
	stats.cpuLoad();
}, 1000);

stats.on('current_load', function(data) {
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

