$(document).ready(function() {
	var visitors = $('#numVisitors'), socket;	
	// updates all clients with the current number of visitors
	updateCount = function(numVisitors){
		visitors.html(numVisitors);
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
}); 