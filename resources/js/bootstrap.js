/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken || document.querySelector('meta[name="csrf-token"]').getAttribute('content');
window.axios.defaults.headers.common['Accept'] = 'application/json';

// if a 419 status code is returned, it means the CSRF token has expired. Refresh the page to get a new token.
/* window.axios.interceptors.response.use(response => response, error => {
  if (error.response.status === 419) {
      window.location.reload();
  }
  return Promise.reject(error);
}); */

// use an interceptior to log requests and responses
/* window.axios.interceptors.response.use(response => {
  let request = response.config
  console.log('Request:', JSON.stringify({
    url: request.url,
    method: request.method,
    headers: request.headers,
    data: request.data
  }))
  console.log('Response:', JSON.stringify({
    status: response.status,
    statusText: response.statusText,
    headers: response.headers,
    data: response.data
  }))
  return response
}) */


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
