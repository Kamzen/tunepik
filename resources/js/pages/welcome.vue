<template>
  <div>
    <div class="top-right links">
      <template v-if="authenticated">
        <router-link :to="{ name: 'home' }">
          <v-button :type="'primary'">{{ $t('home') }}</v-button>
        </router-link>
      </template>
      <template v-else>
        <router-link :to="{ name: 'login' }">
          <v-button :type="'primary'">{{ $t('login') }}</v-button>
        </router-link>
        <router-link :to="{ name: 'register.username' }">
          <v-button :type="'primary'">{{ $t('register') }}</v-button>
        </router-link>
      </template>
    </div>

    <div class="text-center">
      <div class="title mb-4">
        {{ title }}
      </div>

      <!-- <div class="links">
        <a href="https://github.com/cretueusebiu/laravel-vue-spa">github.com/cretueusebiu/laravel-vue-spa</a>
      </div> -->
      <Name style="width:65%;height:100px;"></Name>

    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  layout: 'basic',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}
</style>
