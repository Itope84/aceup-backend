require("@fortawesome/fontawesome-free/js/all")

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}

window.axios.defaults.baseUrl = "/api/super"


try {
  window.Popper = require('popper.js').default;
  window.$ = window.jQuery = require('jquery');
} catch (e) {}


window.axios.defaults.headers.common["Accept"] = "application/json";

window.Vue = require("vue");

// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import 'core-js/es6/promise'
import 'core-js/es6/string'
import 'core-js/es7/array'
// import cssVars from 'css-vars-ponyfill'
import BootstrapVue from 'bootstrap-vue'
import App from './App'
import router from './router'
import store from './store'

Vue.prototype.$eventHub = new Vue()

import VueAWN from 'vue-awesome-notifications'
import vSelect from 'vue-select'
import datePicker from 'vue-bootstrap-datetimepicker'
import VueSweetalert2 from 'vue-sweetalert2'
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css'
import VueCkeditor from 'vue-ckeditor2'

import Alert from "./views/components/Alert.vue"
import EventHub from "./views/components/EventHub.vue"
import VueButtonSpinner from "./views/components/VueButtonSpinner.vue"
// todo
// cssVars()

Vue.use(BootstrapVue)
Vue.use(VueAWN, { position: 'top-right' })
Vue.use(datePicker)
Vue.use(VueSweetalert2)
Vue.use(VueCkeditor)

Vue.component('back-buttton', require('./views/components/BackButton.vue'))
Vue.component('bootstrap-alert', Alert)
Vue.component('event-hub', EventHub)
Vue.component('vue-button-spinner', VueButtonSpinner)
Vue.component('v-select', vSelect)
Vue.component('vue-ckeditor', VueCkeditor)

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: {
    App
  },
  store
})
