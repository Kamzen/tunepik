<template>
  <div class="main-layout">
    
    <template v-if="screen">

      <div class="root-m-element">
        
        <div class="">
          <MobileNavBar />
        </div>

        <div class="contain" style="background-color: #fff;">

          <MobileBaseView />

        </div>

      </div>

    </template>

    <template v-else>

      <div class="root-d-element">

        <DesktopNavBar />

        <div class="container mt-1">
            
            <DesktopBaseView />
        
        </div>

      </div >

    </template>
  </div>
</template>

<script>
import Navbar from '~/components/Navbar'
import globs from '../tunepik/attack.js'

export default {
  name: 'MainLayout',
  data : () => {

    return {

      screen : globs.app.isMobile

    }

  },
  components: {
    Navbar
  }
}
</script>

<style scoped>

  .main-layout{
    overflow-x:hidden;
  }

</style>
