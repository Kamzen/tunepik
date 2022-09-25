<template>
       
       <div class="Wrapper">
         
         <div class="" v-if="postComments.commentsLoading">
         
           <center>
             
             <div class="space-large"></div>
             <div class="app-loader"></div>

           </center>

         </div>
         <div v-else>
           
          <div v-if="postComments.list" class="comments">

              <template v-for="(CommentModel, index) in postComments.comments">

                <CommentBodyBuilder :comment="CommentModel" ></CommentBodyBuilder>

              </template>

           </div>
           <div v-else>
             
             <div class="space-large"></div>
             <div class="app-deleted-post grey-matter p-2">
               
               <center>
                 <span class="app-post-text app-max-text">
                   {{ postComments.message }}
                 </span>
               </center>

             </div>

           </div>

         </div>

       </div>

</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import globs from '../../../tunepik/attack.js'
  import CommentBodyBuilder from './CommentBodyBuilder'

    export default {

        name    : "PostCommentsBundler",
        data    : () => {

          return {

            screen      : globs.app.isMobile,
            mainPost    : null,

          }

        },
        components  : {

          CommentBodyBuilder

        },
        methods   : {

          ...mapActions("posts", ["getPostComments"]),

        },
        computed    : {

          ...mapGetters("posts", ['postComments']),
          Post : function(){

            this.mainPost = this.post;
            return this.mainPost;

          }

        },
        props : ['post'],
        created(){

          this.getPostComments(this.$props.post.getPost().id)

        }

    }
</script>

<style scoped>

</style>
