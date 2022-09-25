<template>

  <div class="app-shared-post grey-matter">

    <router-link :to="{ name : 'comment', params : { username : post.getBasic().handle,  type : post.getPost().type, id : post.getPost().id } }">

      <a @click="MAIN_POST(post)">

        <HeaderBodyBuilder :post="post"></HeaderBodyBuilder>

        <!-- Check If Deleted Or Not -->

        <template v-if="post.getPost().type == 'deleted'">
          
          <DeletedBodyBuilder :post="post"></DeletedBodyBuilder>

        </template>
        <template v-else>
          <div class="share-tex pl-2">
            <TextBodyBuilder :text="post.getPost().text"></TextBodyBuilder>
          </div>
        </template>

        <div class="space-small" ></div>

        <!-- Actual Post -->

        <MediaBodySwitch :post="post"></MediaBodySwitch>

      </a>
      
    </router-link>

  </div>
       
</template>

<script>

  import { mapMutations } from 'vuex'
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
        data    : () => ({
          screen : globs.app.isMobile,
        }), 
        props : ['post'],
        methods : {
          ...mapMutations('posts', ['MAIN_POST'])
        }

    };
</script>

<style scoped>

    .app-shared-post{
      /*border : .03em solid rgba(211, 211, 211, .175);*/
    }

    .share-text{
      padding-left: 
    }

</style>
