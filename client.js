var cpuLoad1Min;
var smoothie = new SmoothieChart({
		grid : {
			strokeStyle : 'rgb(125, 0, 0)',
			fillStyle : 'rgb(0, 60, 0)',
			lineWidth : 1,
			millisPerLine : 250,
			verticalSections : 10,
		},
		labels : {
			fillStyle : 'rgb(255, 255, 255)'
		}
	});

	var line1 = new TimeSeries();
	var line2 = new TimeSeries();
	var line3 = new TimeSeries();

	smoothie.addTimeSeries(line1, {
		strokeStyle : 'rgb(0, 255, 125)',
		fillStyle : 'rgba(0, 255, 125, 0.4)',
		lineWidth : 2
	});
	smoothie.addTimeSeries(line2, {
		strokeStyle : 'rgb(0, 0, 0)',
		fillStyle : 'rgba(0, 60, 0, 0.1)',
		lineWidth : 0
	});
	smoothie.addTimeSeries(line2, {
		strokeStyle : 'rgb(0, 0, 0)',
		fillStyle : 'rgba(0, 60, 0, 0.1)',
		lineWidth : 0
	});
	smoothie.streamTo(document.getElementById("cpuLoad1MinCanvas"), 1000 /*delay*/);
	
		
	// Add a value to each line every second
	setInterval(function() {
		
		line1.append(new Date().getTime(), cpuLoad1Min);
		line2.append(new Date().getTime(), 1.00);
		line3.append(new Date().getTime(), 0.00);
	}, 1000);


$(document).ready(function() {
	var visitors = $('#numVisitors'), socket, load = $('#loadHeader');
	// updates all clients with the current number of visitors
	updateCount = function(numVisitors) {
		visitors.html(numVisitors);
	};

	updateLoad = function(data) {
		cpuLoad1Min = data;
		load.html(data);
	};

	// Connect socket and set up all the packet handlers
	socket = io.connect('http://23.23.183.118:4000');

	// When we receive the init, notify all clients and update the current client
	socket.on('init', function(visitorCount) {
		socket.emit('visitorConnect');
		updateCount(visitorCount);
	});

	// Set up the handlers
	socket.on('visitorConnect', updateCount);
	socket.on('visitorDisconnect', updateCount);
	socket.on('update_load', updateLoad);

	// Data

});	




