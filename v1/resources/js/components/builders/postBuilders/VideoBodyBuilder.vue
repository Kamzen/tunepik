<template>

	<div class="app-image-body main-wrapper">
    
    <a class="media-anchor">
      
      <div class="embed-responsive embed-responsive-1by1">
      	
      	<video class="embed-responsive-item" controls="false" preload="metadata">
      		
      		<source :src="'' + post.getPost().url" />

      	</video>
      
      </div>

    </a>

  </div>
       
</template>

<script>

  import globs from '../../../tunepik/attack.js'

    export default {

        name    : "VideoBodyBuilder",
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
