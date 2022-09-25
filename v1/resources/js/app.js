import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import SvgVue from 'svg-vue'
import Skeleton from 'vue-loading-skeleton'

import '~/plugins'
import '~/components'

Vue.config.productionTip = false

Vue.use(SvgVue)
Vue.use(Skeleton)

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
