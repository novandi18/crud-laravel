window._ = require('lodash');

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo'
import Pusher from "pusher-js"

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: '05cb8b8191b86477fe6c',
  cluster: 'eu',
  forceTLS: true
});

var channel = window.Echo.channel('my-channel');
channel.listen('.my-event', function(data) {
  alert(JSON.stringify(data));
});