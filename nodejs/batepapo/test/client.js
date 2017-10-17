var socket = io('http://localhost:3000');

$(function(){
    $('form').submit(function(){
        socket.emit('mensagem', $('#m').val());
        $('#m').val('');
        return false;
    });
})

socket.on('mensagem', function(msg){
    $('#mensagens').append($('<li>').text(msg));
});
