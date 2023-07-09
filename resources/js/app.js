require('./bootstrap');
window.Pusher = require('pusher-js');
import Echo from "laravel-echo";

const chatForm = document.getElementById('message-form');

const chatMessages = document.getElementById('message-box');
const chatThreads = document.getElementById('message-threads');
const chatThread = document.getElementById('message-thread');
const roomId = document.getElementById('big-box').getAttribute('data-room')
const adminId = chatThreads.getAttribute('data-admin');
chatForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const messageInput = document.getElementById('sent-message');
    const messageInputValue = messageInput.value;
    const messages = chatMessages.querySelectorAll('.message')
    chatMessages.innerHTML += '<div class="message sent"><div class="message-content"><p class="text-white">' + messageInputValue + '</p></div></div>';
    messageInput.value = ''


    axios.post('/admin/chat/broadcast', {
        message: messageInputValue, room: roomId, sent_by_admin: 1
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
                axios.post('broadcasting/auth', {
                    socket_id: socketId, channel_name: channel.name
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
echo.join('chat_message.' + roomId)
    .listen('.chat-message', (data) => {
        const message = `
            <div class="message received"><div class="message-content"><p>${data.message.message}</p></div></div>`;
        chatMessages.innerHTML += message;
    });
echo.private('chat_room.' + adminId)
    .listen('.room-create', (data) => {
        console.log(data)
        let room = ''
        if (data.room.sender_type === 'App\\Models\\Technician') {
            room = `
                <li class="list-group-item" style="cursor: pointer">
                    <img class="img-fluid mx-1"
                         style="border-radius: 50%; width: 20px; height: 20px"
                         src="http://127.0.0.1:8000/${data.sender.image}" alt="">${data.sender.phone}فني -
                    <br>${data.sender.name}
                </li>`
        }else {
             room = `
                <li class="list-group-item" style="cursor: pointer"
                    >
                    ${data.sender.phone}عميل  -
                    <br>${data.sender.first_name}  -  ${data.sender.last_name}
                </li>`
        }
        chatThread.innerHTML += room;
    });


