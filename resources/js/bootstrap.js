/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
//Import jQuery
import $ from 'jquery';
window.$ = window.jQuery = $;
//Import seletec2
import select2 from 'admin-lte/plugins/select2/js/select2.full.min.js'
select2()
//Import sweetalert2
import Swal from 'sweetalert2'
window.Swal = Swal;
import ApexCharts from 'apexcharts'
window.ApexCharts = ApexCharts;
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 *
 * Pusher.logToConsole = true;

var pusher = new Pusher('d49b662cce46bbf35ee1', {
    cluster: 'ap2'
});

var channel = pusher.subscribe('afia-channel');
channel.bind('bill-created', function (data) {
    alert(JSON.stringify(data));
});

 *
 *
 *
 */

