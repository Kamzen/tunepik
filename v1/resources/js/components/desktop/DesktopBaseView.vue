<template>
       
      <div class="app-desktop-base-view">
        
        <div class="row">

        <div class="col-lg-2 icon-nav-wrapper app-col" style="">
          
          <div class="space-large" ></div>
          <IconNav ></IconNav>

        </div> <!-- End of Col-lg-2 -->

        <div class="col-lg-10 app-col">
            
            <child ></child>

        </div>  <!-- End Of App View  End Of Col-lg-10 -->


        </div> <!-- End Of Row -->

      </div>

</template>

<script>
  import {mapGetters} from 'vuex';

    export default {
        name: "DesktopBaseView",
        
    }
</script>

<style scoped>

.app-col{
  padding-bottom : 3%;
}

</style>