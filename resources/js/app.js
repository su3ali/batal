require('./bootstrap');
window.Pusher = require('pusher-js');
import Echo from "laravel-echo";
const chatForm = document.getElementById('message-form');

const chatMessages = document.getElementById('message-box');
const roomId = document.getElementById('big-box').getAttribute('data-room')

chatForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const messageInput = document.getElementById('sent-message');
    const messageInputValue = messageInput.value;
    const messages = chatMessages.querySelectorAll('.message')
    chatMessages.innerHTML += '<div class="message sent"><div class="message-content"><p class="text-white">' + messageInputValue + '</p></div></div>';
    messageInput.value = ''


    axios.post('/admin/chat/broadcast', {
        message: messageInputValue,
        room: roomId,
    })
        .catch((error) => {
            console.log(error);
        });
});

const echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});
let pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true
});
let channel = pusher.subscribe('chat-room' + roomId);
channel.bind('message-sent', function (data) {
    console.log(data)
    var message = data.message;
    var user = data.user;

    var messageHtml = '<div class="message">' +
        '<strong>' + user.name + ':</strong> ' + message +
        '</div>';

    chatMessages.innerHTML += messageHtml;
});
echo.channel('chat-room')
    .listen('.App\\Events\\MessageSent', (data) => {
        const message = `
            <div class="message received"><div class="message-content"><p>${data.message}</p></div></div>
        `;
        console.log(data)
        chatMessages.innerHTML += message;
    });

