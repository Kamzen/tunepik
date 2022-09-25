<template>
       
      <div class="app-desktop-base-view wrapper">
        
        <div class="row">
          
          <div class="col-lg-1 app-col"></div>

        <div class="col-lg-2 icon-nav-wrapper app-col" style="">

        </div>

        <div class="col-lg-6 app-col">
          
          <div class="posts-wrapper" style="width:100%;">
            
            <child />

          </div>

        </div>

        <div class="col-lg-3 app-col"></div>


        </div>
        
      </div>

</template>

<script>
  import {mapGetters} from 'vuex';

    export default {
        name: "MobileBaseView",
        scrollToTop : false,
        
    }
</script>

<style scoped>



</style>