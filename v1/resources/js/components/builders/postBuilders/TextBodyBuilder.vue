<template>
    
    <span class="app-post-text container-fluid app-post-text-wrapper main-wrapper" v-if="post.getPost().text != ''">{{ post.getPost().text }}</span>
    <span v-else></span>
    
</template>

<script>

  import globs from '../../../tunepik/attack.js'

    export default {

        name    : "TextBodyBuilder",
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
