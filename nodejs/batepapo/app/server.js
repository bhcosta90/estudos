var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

// Definimos aqui uma rota "/" que ser� chamada quando acessarmos a p�gina inicial da nossa aplica��o
app.get('/', function(req, res){
    res.send('<h1>Ol� Mundo!</h1>');
});

io.on('connection', function(socket){
    console.log('logado');
    socket.on('mensagem', function(msg){
        io.emit('mensagem', msg);
    });
});

// Definimos a porta 3000 para nos servir a aplica��o
http.listen(3000, function(){
    console.log('listening on *:3000');
});
