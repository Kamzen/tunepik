<template>

<div class="post-breaker">
  <div class="app-media-body-main">
    
    <div class="app-media-body">

        <!-- Create Post Header! -->

         <HeaderBodyBuilder :post="post"></HeaderBodyBuilder>

            <!-- Check If Deleted Or Not -->

            <!-- Actual Post -->

            <MediaBodySwitch :post="post"></MediaBodySwitch>
              
              <DeletedBodyBuilder :post="post" v-if="post.getPost().type == 'deleted'"></DeletedBodyBuilder>
              
              <TextBodyBuilder class="" :text="post.getPost().text" v-else></TextBodyBuilder>

            <template v-if="!post.getStats().isOriginal">

              <div class="space-small"></div>

              <ShareBodyBuilder class="app-shared-post grey-matter" :post="post.getShare().model"></ShareBodyBuilder>

            </template>

            <!-- Reaction Body Wrapper -->

            <div class="">

              <ReactionBodyBuilder :post="post"></ReactionBodyBuilder>

            </div>

      </div>

      <!-- Show One Comment If Post Has Comment! -->
        
        <div class="feed-comment-wrapper mt-1 pt-2 no-border" v-if="post.getComment().has && comments">
          
           <CommentBodyBuilderTwo :comment="post.getComment().comment" class="pl-2 pr-2"></CommentBodyBuilderTwo>

           <div class="extra-comments pl-3" v-if="post.getStats().comCount > 1">
             <a>
               <span class="app-grey-text">view all {{ post.getStats().comCount  }} comments</span>
             </a>
           </div>

        </div>

      <!-- <div class="space-large visible-lg"></div> -->
      <div class="space-medium visible-sm"></div>

    </div>

    <div class="space-small" v-if="!screen">
      
    </div>
</div>

</template>

<script>
  import {mapGetters} from 'vuex';
  import globs from '../../tunepik/attack.js'
  import HeaderBodyBuilder from './postBuilders/HeaderBodyBuilder'
  import MediaBodySwitch from './postBuilders/MediaBodySwitch'
  import TextBodyBuilder from './postBuilders/TextBodyBuilder'
  import DeletedBodyBuilder from './postBuilders/DeletedBodyBuilder'
  import ReactionBodyBuilder from './postBuilders/ReactionBodyBuilder'
  import ShareBodyBuilder from './postBuilders/ShareBodyBuilder'
  import CommentBodyBuilderTwo from './commentBuilders/CommentBodyBuilderTwo'


    export default {

        name        : "Post",
        scrollToTop : false,
        data    : () => ({
          screen : globs.app.isMobile
        }),
        components  : {
          MediaBodySwitch,
          TextBodyBuilder,
          DeletedBodyBuilder,
          ReactionBodyBuilder,
          HeaderBodyBuilder,
          ShareBodyBuilder,
          CommentBodyBuilderTwo
        },
        props       : ['post', 'comments']

    };

</script>

<style scoped>

  .app-media-body-main{

  }

  @media only screen and (max-width : 700px){

    .app-media-body-main{

      /*border-bottom: .05em solid rgba(211, 211, 211, .175);*/

    }

    /*.feed-comment-wrapper{

       border-top: .05em solid rgba(211, 211, 211, .4);

    }*/

    .app-media-body,
    .app-viewport-top{
      width :100%;
      height: 100%;
      object-fit: contain;
      background-color: transparent;
      margin: auto;
    }

  }

  @media only screen and (min-width : 700px){

    /*.app-media-body-main{
      border: .04em solid rgba(211, 211, 211, .200);
    }*/

    .post-breaker{
      border-bottom: .04em solid rgba(211, 211, 211, .175);
      margin-bottom: 15px;
    }

    .app-media-body{
      width :100%;
      height: auto;
      background-color: transparent;
    }

  }


</style>
