require('./bootstrap');
window.Pusher = require('pusher-js');
import Echo from "laravel-echo";
alert('welcomechat')
const chatForm = document.getElementById('message-form');

const chatMessages = document.getElementById('message-box');
const chatThreads = document.getElementById('message-threads');
const chatThread = document.getElementById('message-thread');
var roomId = document.getElementById('big-box').getAttribute('data-room')
setInterval(function () {
    roomId = document.getElementById('big-box').getAttribute('data-room');
}, 1000);

const adminId = chatThreads.getAttribute('data-admin');

document.getElementById('message-form').addEventListener('submit', (e) => {
    e.preventDefault();

    const messageInput = document.getElementById('sent-message');
    const messageInputValue = messageInput.value;
    const messages = chatMessages.querySelectorAll('.message');
    const roomId = document.getElementById('big-box').getAttribute('data-room')

    // chatMessages.innerHTML += '<div class="message sent"><div class="message-content"><p class="text-white">' + messageInputValue + '</p></div></div>';
    chatMessages.innerHTML += '<li class="message sent"><img src="/images/user.jpg" alt=""/> <p>' + messageInputValue + '</p></li>';
    messageInput.value = ''


    axios.post('/admin/chat/broadcast', {
        message: messageInputValue, room: roomId, sent_by_admin: 1
    })
        .catch((error) => {
            console.log(error);
        });

    let BoxMessages = document.getElementById("big-box")
    BoxMessages.scrollTo(0, BoxMessages.scrollHeight);

});
const echo = new Echo({
    broadcaster: 'pusher',
    key: '87ed15aef6ced76b1507',
    cluster: 'us2',
    forceTLS: true,
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
        console.log(data)
        if (data.message.sent_by_admin === 0){
            // const message = `<div class="message received"><div class="message-content"><p>${data.message.message}</p></div></div>`;
            const message = `<li class="message received"><img src="/images/techn.png" alt=""/> <p>${data.message.message}</p></li>`;
            chatMessages.innerHTML += message;

            let BoxMessages = document.getElementById("big-box")
            BoxMessages.scrollTo(0, BoxMessages.scrollHeight);
        }

    });
echo.private('chat_room.' + roomId)
    .listen('.room-create', (data) => {
        console.log(data)
        let str = data.message.message;
        if (str.length > 20) {
            str = str.substring(0, 20) + "...";
        }
        let room = ''
        const url = process.env.APP_URL;
        if (data.room.sender_type === 'App\\Models\\Technician') {
            room = `
                <li class="list-group-item " style="cursor: pointer; background-color: #DDD">
                    <img class="img-fluid mx-1"
                         style="border-radius: 50%; width: 20px; height: 20px"
                         src="${url}/${data.sender.image}" alt="">${data.sender.name}
                    <br>${str}
                </li>`
        }else {
             room = `
                <li class="list-group-item " style="cursor: pointer; background-color: #DDD"
                    >
                    عميل - ${data.sender.first_name}  ${data.sender.last_name}
                    <br>${str}
                </li>`
        }
        chatThread.innerHTML += room;
    });


