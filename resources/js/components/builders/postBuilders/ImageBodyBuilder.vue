<template>

  <div class="app-image-body main-wrapper">
    
    <a class="media-anchor">
      
     <!--  <div class="image-loader skeleton-shimmer" v-if="img.onload"></div> -->
      <img class="img-fluid" :src="thumb ? post.getPost().thumbUrl : post.getPost().url" ref="image"/>
      <!-- <image-loader 
        class="img-fluid app-image-body image"
        :src="'' + post.getPost().url"
      /> -->

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
        props : ['post', 'thumb'],
        computed : {

          img : function(){

            return this.$refs.image

          }

        }

    };
</script>

<style scoped>

  .image{

    width: 100%;
    height: auto;

  }

  .image-loader{

    width: 100%;
    height: 300px;

  }

</style>
