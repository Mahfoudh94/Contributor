import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-Timezone'] =
    Intl.DateTimeFormat().resolvedOptions().timeZone;
