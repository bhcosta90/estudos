var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

// Definimos aqui uma rota "/" que será chamada quando acessarmos a página inicial da nossa aplicação
app.get('/', function(req, res){
    res.send('<h1>Olá Mundo!</h1>');
});

io.on('connection', function(socket){
    console.log('logado');
    socket.on('mensagem', function(msg){
        io.emit('mensagem', msg);
    });
});

// Definimos a porta 3000 para nos servir a aplicação
http.listen(3000, function(){
    console.log('listening on *:3000');
});
