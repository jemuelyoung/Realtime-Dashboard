var events = require('events');
var util = require('util');
var exec = require('child_process').exec;
var numProcessors;

function Statistics() {
	if (false === (this instanceof Statistics)) {
		return new Statistics();
	}
	events.EventEmitter.call(this);

	// get the number of processors
	exec("grep 'model name' /proc/cpuinfo | wc -l", function(error, stdout, stderr) {
		numProcessors = parseInt(stdout);
		if (error !== null) {
			console.log('exec error: ' + error);
		}
	});
}

util.inherits(Statistics, events.EventEmitter);

Statistics.prototype.cpuLoad = function() {
	var self = this, load;
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

module.exports = new Statistics();
