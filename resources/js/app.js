import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import SvgVue from 'svg-vue'
// import Skeleton from 'vue-loading-skeleton'
import VueMasonry from 'vue-masonry-css'
import VueRx from 'vue-rx'
import VuejsClipper from 'vuejs-clipper'
import VueWaveSurfer from 'vue-wave-surfer'
import VueImageLoader from '@kevindesousa/vue-image-loader'

import '~/plugins'
import '~/components'

Vue.config.productionTip = false

Vue.use(SvgVue)
Vue.use(VueMasonry)
Vue.use(VueRx)
Vue.use(VuejsClipper, {

  components: {

    clipperFixed: true,
    clipperUpload: true,
    clipperPreview: true,
    clipperRange: true,
    clipperBasic: true

  }

})

Vue.use(VueWaveSurfer)
Vue.use(VueImageLoader)

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
