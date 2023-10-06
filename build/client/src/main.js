import Vue from 'vue'
import App from './App.vue'
import router from '@/plugins/router'
import store from '@/plugins/store'
import '@/assets/style.sass'
import '@/plugins/uikit'
import '@/plugins/utils'
import '@/plugins/mixin'
import '@/plugins/socket'

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: function (h) { return h(App) }
}).$mount('#app')
