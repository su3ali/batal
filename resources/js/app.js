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
        sent_by_admin: 1
    })
        .catch((error) => {
            console.log(error);
        });
});

const echo = new Echo({
    broadcaster: 'pusher',
    key: '87ed15aef6ced76b1507',
    cluster: 'us2',
    forceTLS: false,
    authorizer: (channel, options) => {
        return {
            authorize: (socketId, callback) => {
                axios.post('/admin/chat/auth', {
                    socket_id: socketId,
                    channel_name: channel.name
                }, {
                    progress: false,
                })
                    .then(response => {
                        callback(false, response.data);
                    })
                    .catch(error => {
                        callback(true, error);
                    });
            }
        };
    },
});
// const pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER
// });
//
// const channel = pusher.subscribe('chat_message.1');
// alert(222223)
// channel.bind('MessageSentEvent', function(data) {
//     console.log('Received event with data:', data);
// });
// echo.channel('chat_message.'+roomId)
echo.join('chat_message.1')
    .listen('chat.message', (data) => {
        const message = `
            <div class="message"><div class="message-content"><p>${data.message}</p></div></div>
        `;
        console.log(data)
        chatMessages.innerHTML += message;
    });

