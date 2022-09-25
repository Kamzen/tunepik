<template>
       
      <div class="app-desktop-base-view">
        
        <div class="row">

        <div class="col-lg-2 app-col">
          
          <div class="left-fixed-wrapper wrapper">
            
            <div class="name-wrap pt-3 pl-5 pr-5" style="width:60%;">
              <name></name>
            </div>

            <div class="space-large"></div>

            <desktop-nav class="pl-4 pr-5"></desktop-nav>

            <div class="space-large"></div>

            <story-header class="pl-2" v-if="!screen">
              <story-grid-bundler :url="storyURL"></story-grid-bundler>
            </story-header>

            <snack-bar v-if="screen"></snack-bar>

          </div>

        </div> <!-- End of Col-lg-2 -->

        <div class="col-lg-10 app-col main-body-desk">
            <div class="breaker" v-if="!screen"></div>
            <child></child>

        </div>  <!-- End Of App View  End Of Col-lg-10 -->

        </div> <!-- End Of Row -->

      </div>

</template>

<script>
  import {mapGetters} from 'vuex';
  import DesktopNav from './DesktopNav'
  import StoryHeader from '../builders/storyBuilders/StoryHeader'
  import StoryGridBundler from '../builders/storyBuilders/StoryGridBundler'
  import globs from '../../tunepik/attack.js'

    export default {
       name: "DesktopBaseView",
       data   : () => ({
        storyURL : '/api/stories/all',
        screen : globs.app.isMobile
       }),
       components : {
        DesktopNav,
        StoryHeader,
        StoryGridBundler
       },
       computed : {

       }
    };
</script>

<style scoped>

.breaker{
  height: 70px;
}

.app-col{
  padding-bottom : 3%;
}

.col-lg-10{
  position: relative;
  left: 10px;
  width: 100%;
}

.col-lg-2{
  background-color: transparent !important;
}

.row,
.app-desktop-base-view{
  background-color: transparent;
}

.left-fixed-wrapper{
  position: fixed;
  left: 0;
  top: 0;
  bottom: 0;
  right: 0;
  width: 25%;
  height: 100%;
  border-right: .05em solid rgba(211, 211, 211, .175);
  z-index: 99999 !important;
}

</style>