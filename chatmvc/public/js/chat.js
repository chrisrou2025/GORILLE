var msgBox = $('#message-box');
var wsUri = "ws://localhost:9000";
var websocket = new WebSocket(wsUri);

websocket.onopen = function(ev) {
    msgBox.append('<div class="system_msg" style="color:#bbbbbb">Welcome to my "Demo WebSocket Chat box"!</div>');
};

websocket.onmessage = function(ev) {
    var response = JSON.parse(ev.data);
    var res_type = response.type;
    var user_message = response.message;
    var user_name = response.name;
    var user_color = response.color;

    switch (res_type) {
        case 'usermsg':
            msgBox.append('<div><span class="user_name" style="color:' + user_color + '">' + user_name + '</span> : <span class="user_message">' + user_message + '</span></div>');
            break;
        case 'system':
            msgBox.append('<div style="color:#bbbbbb">' + user_message + '</div>');
            break;
    }
    msgBox[0].scrollTop = msgBox[0].scrollHeight;
};

websocket.onerror = function(ev) {
    console.error('Erreur WebSocket : ', ev);
    msgBox.append('<div class="system_error">Erreur de connexion au serveur</div>');
};

websocket.onclose = function(ev) {
    msgBox.append('<div class="system_msg">Connexion fermée</div>');
};

$('#send-message').click(function() {
    send_message();
});

$("#message").on("keydown", function(event) {
    if (event.which == 13) {
        send_message();
    }
});

function send_message() {
    var message_input = $('#message');
    var name_input = $('#name');
    var color_input = $('#color');
    var room_input = $('#room');

    if (message_input.val() === "") {
        alert("Entrez un message !");
        return;
    }

    var msg = {
        message: message_input.val(),
        name: name_input.val(),
        color: color_input.val() || '#000000',
        room: room_input.val()
    };

    websocket.send(JSON.stringify(msg));
    store_message(msg);
    message_input.val('');
}

function store_message(msg) {
    if (!msg.message || !msg.name || !msg.room) {
        console.error('Missing required fields:', msg);
        msgBox.append('<div class="system_error">Champs requis manquants</div>');
        return;
    }

    $.post('../../chat/insert', {
        message: msg.message,
        name: msg.name,
        color: msg.color,
        room: msg.room
    })
    .done(function(response) {
        console.log('Message stored successfully:', response);
        try {
            var res = JSON.parse(response);
            if (res.status === 'error') {
                msgBox.append('<div class="system_error">' + res.message + '</div>');
            }
        } catch (e) {
            console.log('Response not JSON:', response);
        }
    })
    .fail(function(error) {
        console.error('Error storing message:', error);
        msgBox.append('<div class="system_error">Erreur serveur: ' + (error.statusText || 'Inconnu') + '</div>');
    });
}