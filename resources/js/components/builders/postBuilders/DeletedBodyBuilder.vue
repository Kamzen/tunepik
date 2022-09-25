<template>

  <div class="app-deleted-post grey-matter container-fluid mt-2 mb-2">
    
    <span class="app-post-text align-center">{{ post.getPost().text }}</span>

  </div>
       
</template>

<script>

  import globs from '../../../tunepik/attack.js'

    export default {

        name    : "DeletedBodyBuilder",
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
