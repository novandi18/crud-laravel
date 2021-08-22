const { default: axios } = require('axios');

require('./bootstrap');

const element = document.getElementById("messages");
const username = document.getElementById("username");
const name = document.getElementById("name");
const to_name = document.getElementById("to_name");
const input = document.getElementById("input");
const form = document.getElementById("message_form");

form.addEventListener('submit', (e) => {
    e.preventDefault();

    let err = false;

    if(input.value == '') {
        err = true;
    }

    if(err) {
        return;
    }
    
    const options = {
        method: 'post',
        url: '/message',
        data: {
            name: name.value,
            to_name: to_name.value,
            username: username.value,
            receiver: document.getElementById('receiver').value,
            message: input.value
        }
    }

    axios(options);
    input.value = '';
});

window.Echo.channel('chat').listen('.message', (e) => {
    let date = new Date();

    if(e.username == document.getElementById('receiver').value) {
        element.innerHTML += "<div class='d-flex align-items-center justify-content-between w-100 pt-1 pb-1'><span style='font-size: .9em' class='bg-primary text-white px-2 py-1 rounded'>" + e.message + "</span><span class='text-secondary' style='font-size: .7em'>" + date.getHours() + ":" + date.getMinutes() + "</span></div>";
    } else {
        element.innerHTML += "<div class='d-flex justify-content-between align-items-center w-100 pt-1 pb-1' id='auth'><span class='text-secondary' style='font-size: .7em'>" + date.getHours() + ":" + date.getMinutes() + "</span><span style='margin-left: .5em; font-size: .9em' class='bg-secondary text-white px-2 py-1 rounded'>" + e.message + "</span></div>";
    }
});
