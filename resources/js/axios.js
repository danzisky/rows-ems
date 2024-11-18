import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken || document.querySelector('meta[name="csrf-token"]').getAttribute('content');
axios.defaults.headers.common['Accept'] = 'application/json'
axios.defaults.headers.common['Referer'] = window.location.origin;
