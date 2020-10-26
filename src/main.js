import Vue from 'vue'
import App from './App.vue'
import store from './store/index'
import VueTheMask from 'vue-the-mask'
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue'
import Vuex from 'vuex';

window.$ = require("jquery")
window.axios = require('axios').default;

Vue.use(Vuex);

Vue.use(VueTheMask)

// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

Vue.config.productionTip = false

new Vue({
    store,
    render: h => h(App),
}).$mount('#app')
