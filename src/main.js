import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store/store'
import './registerServiceWorker'
import axios from 'axios'
import Vuelidate from 'vuelidate'
// npm install --save awesome-mask
// npm install --save vue-recaptcha
// npm install dotenv
// npm i --save pretty-checkbox-vue
// npm install --save jquery
// npm install vue-slick
// npm install --save v-photoswipe

import 'pretty-checkbox/dist/pretty-checkbox.css'
// import 'pretty-checkbox-vue/dist/pretty-checkbox-vue.js'
import PrettyCheckbox from 'pretty-checkbox-vue'

require('dotenv').config()
Vue.config.productionTip = false
Vue.use(Vuelidate)
Vue.use(PrettyCheckbox)
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded'

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
