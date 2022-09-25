<template>

  <div class="app-image-body main-wrapper">
    
    <a class="media-anchor">
      
      <img class="img-fluid rounded" :src="'' + post.getPost().url" />

    </a>

  </div>
       
</template>

<script>

  import globs from '../../../tunepik/attack.js'

    export default {

        name    : "ImageBodyBuilder",
        data    : () => {

          return {

            screen : globs.app.isMobile

          }

        }, 
        props : ['post']

    }
</script>

<style scoped>

</style>
