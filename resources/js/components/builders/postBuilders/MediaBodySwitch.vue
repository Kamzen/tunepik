<template>

  <div class="wrapper-main-post">

    <!-- Image Only Body Rendering -->
    
    <template v-if="post.getPost().type == 'image' || post.getPost().type == 'photo'">

      <ImageBodyBuilder :post="post"></ImageBodyBuilder>

    </template>

    <!-- Video Only Body Rendering -->

    <template v-else-if="post.getPost().type == 'video'">
      

      <VideoBodyBuilder :post="post"></VideoBodyBuilder>

    </template>

    <!-- Audio Only Body Rendering -->

    <template v-else-if="post.getPost().type == 'audio' || post.getPost().type == 'theme-audio'">
      
      <AudioBodyBuilder :url="post.getPost().url" :id="post.getPost().id" ></AudioBodyBuilder>

    </template>

    <!-- Text Only Body Rendering -->

    <!-- <template v-else-if="post.getPost().type == 'text' || post.getPost().deleted">
      
      <div class=""></div>

    </template> -->

  </div>
       
</template>

<script>

  import globs from '../../../tunepik/attack.js'
  import ImageBodyBuilder from './ImageBodyBuilder'
  import VideoBodyBuilder from './VideoBodyBuilder'
  import AudioBodyBuilder from './AudioBodyBuilder'

    export default {

        name        : "MediaBodySwitch",
        components  : {

          ImageBodyBuilder,
          VideoBodyBuilder,
          AudioBodyBuilder

        },
        data        : () => {

          return {

            screen : globs.app.isMobile

          }

        }, 
        props       : ['post']

    }
</script>

<style scoped>

</style>
