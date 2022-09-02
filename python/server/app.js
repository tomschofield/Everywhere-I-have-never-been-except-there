var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

app.get('/', function(req, res) {

    //send the index.html file for all requests
    res.sendFile('/Users/ntws2/Desktop/probe_requests/client/index.html');

});

// http.listen(3001, function() {

//     console.log('listening on *:3001');

//     io.on('news', function(data) {
//         console.log("got", data);
//     });

// });


io.on('connection', function(socket) {
    socket.on('news', function(msg) {
        console.log('message: ' + msg);
        io.emit('news', msg);
    });
});

http.listen(3001, function() {
    console.log('listening on *:3001');
});

// //for testing, we're just going to send data to the client every second
// setInterval(function() {

//     /*
//       our message we want to send to the client: in this case it's just a random
//       number that we generate on the server
//     */
//     var msg = Math.random();
//     io.emit('message', msg);
//     console.log(msg);

// }, 1000);