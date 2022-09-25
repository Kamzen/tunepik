<template>

  <div class="app-shared-post grey-matter">

    <HeaderBodyBuilder :post="post"></HeaderBodyBuilder>

    <!-- Check If Deleted Or Not -->

    <template v-if="post.getPost().type == 'deleted'">
      
      <DeletedBodyBuilder :post="post"></DeletedBodyBuilder>

    </template>
    <template v-else>
      
      <TextBodyBuilder :post="post"></TextBodyBuilder>

    </template>

    <div class="space-small" ></div>

    <!-- Actual Post -->

    <MediaBodySwitch :post="post"></MediaBodySwitch>

  </div>
       
</template>

<script>

  import globs from '../../../tunepik/attack.js'
  import HeaderBodyBuilder from './HeaderBodyBuilder'
  import MediaBodySwitch from './MediaBodySwitch'
  import TextBodyBuilder from './TextBodyBuilder'
  import DeletedBodyBuilder from './DeletedBodyBuilder'

    export default {

        name        : "ShareBodyBuilder",
        components  : {

          HeaderBodyBuilder,
          MediaBodySwitch,
          TextBodyBuilder,
          DeletedBodyBuilder

        },
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
