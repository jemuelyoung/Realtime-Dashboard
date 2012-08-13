var io = require('socket.io').listen(4000),
    visitors;

io.sockets.on('connection', function(socket) {
    // When a client connects, send them the number of visitors
    visitors = io.sockets.clients().length.toString();
    socket.emit('init', visitors);

	// when a new visitor arrives
    socket.on('visitorConnect', function() {
    	visitors = io.sockets.clients().length.toString();
    	console.log('visits: ' + visitors);
    	// update all clients with the new count
           socket.broadcast.emit('visitorConnect', visitors);
    });
    
    socket.on('disconnect', function() {  
    	 visitors = io.sockets.clients().length -1 ;
    	// update all clients with the new count
           socket.broadcast.emit('visitorDisconnect', visitors);
    });
    
});

