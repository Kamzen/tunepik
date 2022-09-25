<template>
  <div class="main-layout" :class="theme.type">

    <template v-if="screen">

      <div class="root-m-element">

        <Navigation>

          <div class="media-body align-self-center">

            <div class="media">
              <div class="media-left">
                <Name></Name>
              </div>
              <div class="media-body"></div>
            </div>

          </div>
          <div class="media-right align-self-center">
            <Picture :user="model" :width="30" :height="30"></Picture>
          </div>

        </Navigation>

        <div class="">
          <mobile-nav-bar />
        </div>

        <div class="contain wrapper">
          <mobile-base-view />
        </div>

      </div>

    </template>

    <template v-else>

      <div class="root-d-element">
        <desktop-nav-bar />
        <div class="container mt-1">
          <desktop-base-view />
        </div>

      </div >

    </template>
  </div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex'
import Navbar from '~/components/Navbar'
import globs from '../tunepik/attack.js'
import Navigation from '../components/mobile/root/Navigation'

export default {
  name: 'MainLayout',
  data : () => ({
    screen : globs.app.isMobile
  }),
  components: {
    Navbar,
    Navigation
  },
  methods  : {
    ...mapActions("tunepik", ['backgroundColor']),
  },
  computed : {
    ...mapGetters("tunepik", ['theme']),
    ...mapGetters('auth', ['model']),
  },
  beforeMount : function() {
    this.$nextTick(function(){
      this.backgroundColor();
    });
  },
  mounted : function(){
  }

};

</script>

<style scoped>

  .main-layout{
    overflow-x:hidden;
    height: 100%;
    width: 100%;
  }

  .root-m-layout{
    position: fixed;
    top : 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    z-index: 1 !important;
    overflow-x: 0;
  }

</style>
