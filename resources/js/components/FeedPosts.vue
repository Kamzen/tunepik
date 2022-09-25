<template>
       
       <PostsBundler :posts="Posts" :type="type" :loading="loading" :list="list" :message="message"></PostsBundler>

</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import globs from '../tunepik/attack.js'
  import PostsBundler from './builders/postBuilders/PostsBundler'

    export default {

        name    : "FeedPosts",
        data    : () => {

          return {

            screen      : globs.app.isMobile,
            listPosts   : false,
            type        : 'list'

          }

        },
        components : {

          PostsBundler

        },
        methods   : {

          ...mapActions("posts", ["getPosts"])

        },
        computed    : {

          ...mapGetters("posts", ['Posts', 'message']),
          ...mapGetters("posts", ['list']),
          ...mapGetters("posts", ['loading']),
          hasPosts : function (){

            this.listPosts = this.list;

            return this.listPosts;

          }

        },
        created(){

          if(!this.hasPosts){

            this.getPosts({url : '/api/posts/feed'});

          }

        }

    };
</script>

<style scoped>

</style>
