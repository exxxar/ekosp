import Vue from 'vue'
import App from './App.vue'
import store from './store/index'
import VueTheMask from 'vue-the-mask'
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue'
import Vuex from 'vuex';
import Notifications from 'vue-notification'
import VueScrollTo from 'vue-scrollto';

Vue.use(VueScrollTo)
window.$ = require("jquery")
window.axios = require('axios').default;
window.FileDownload = require('js-file-download');

Vue.use(Vuex);
Vue.use(Notifications)
Vue.use(VueTheMask)

Vue.component(
    'request-form',
    require('./components/ReuestForm.vue').default
);


Vue.component(
    'calc-form',
    require('./App.vue').default
);


// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

Vue.config.productionTip = false

new Vue({
    store,
    render: h => h(App),
}).$mount('#app')
