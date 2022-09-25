<template>

	<div class="row" style="">
       <div class="col-lg-8 post-viewport-wrapper-lg" style="">
         <div class="post-viewport">
          <a class="app-modal-lg-btn btn btn-sm" v-on:click="back()" v-if="!screen">

          	<svg-vue icon="back" class="app-icon"></svg-vue>

           </a>

              <div class="" v-if="atComments.postLoading">

                <Navigation v-if="screen">

                  <div class="media-body ml-2 align-self-center">
                    
                    <div class="skeleton-shimmer skeleton-name"></div>

                  </div>
                  <div class="media-right align-self-center">
                    
                    <div class="skeleton-shimmer skeleton-btn"></div>

                  </div>

                </Navigation>
                
                <SinglePostSkeleton></SinglePostSkeleton>

              </div>
              <div class="" v-else>

              	<template v-if="screen">

                  <!-- NAVIGATION -->
                  <Navigation>
                    
                    <div class="media-body align-self-center">
                        
                        <span class="app-max-text text-top">
                          Full Post
                        </span>
                      
                    </div>

                    <div class="media-right align-self-center">

                      <router-link :to="{ name : 'createcomment', params : { 
                        username : atComments.post.getBasic().handle,
                        type : atComments.post.getPost().type,
                        id : atComments.post.getPost().id,
                       } 
                     }" >
                       <v-button :type="'primary'" class="btn-top">
                        Add Comment
                       </v-button>
                      </router-link>
                      
                    </div>

                  </Navigation>

			           	<!-- <Post :post="atComments.post" :comments="false"></Post> -->
                  <CommentPost :post="atComments.post"></CommentPost>

			           </template>
			           <template v-else>

                  <!-- <div class="desk-media-wrap">

			           		<MediaBodySwitch :post="atComments.post"></MediaBodySwitch>

                  </div> -->
                  <MediaBodySwitch class="desk-media-wrap" :post="atComments.post"></MediaBodySwitch>

			           </template>
              </div>

         </div>

       </div>
       <div class="col-lg-4 comments-viewport-main darkmode-wrapper wrapper">

        <div class="app-comment-header-fixed" v-if="!screen">

         <div class="visible-lg app-post-owner-header">

         			<!-- Show User Details Of The Post And Any Text Needed For Text -->

         	 <div class="" v-if="atComments.postLoading">
         			<center>
	              <div class="app-loader" ></div>
	           </center>

	          </div>
	          <div class="pt-2" v-else>

	           <HeaderBodyBuilder :post="atComments.post"></HeaderBodyBuilder>

	           <template v-if="atComments.post.getPost().type == 'deleted'">

              <DeletedBodyBuilder :post="atComments.post"></DeletedBodyBuilder>

            </template>
            <template v-else>

              <TextBodyBuilder :text="atComments.post.getPost().text"></TextBodyBuilder>

            </template>

            <!-- Actual Shared Post -->

            <template v-if="!atComments.post.getStats().isOriginal">

              <div class="space-small"></div>
              <ShareBodyBuilder :post="atComments.post.getShare().model"></ShareBodyBuilder>

            </template>

            <!-- Reaction Body Wrapper -->

            <div class="">
              <div class="space-small" ></div>
              <ReactionBodyBuilder :post="atComments.post"></ReactionBodyBuilder>
            </div>

           </div>

            <!-- End -->

         </div>

       </div>

       <!-- Everything Posts End Here -->
         <!-- Show Comments! -->
         <div class="comments-viewport" v-if="!atComments.postLoading">
           <PostCommentsBundler :post="atComments.post"></PostCommentsBundler>
         </div>


       </div>
       <div class="visible-xs space-large"></div>
       <div class="visible-xs space-large"></div>
       <div class="visible-lg space-large"></div>



    </div>

</template>

<script>

  import globs from '../../../tunepik/attack.js'
  import {mapGetters, mapActions} from 'vuex'
  import MediaBodySwitch from '../postBuilders/MediaBodySwitch'
  import DeletedBodyBuilder from '../postBuilders/DeletedBodyBuilder'
  import TextBodyBuilder from '../postBuilders/TextBodyBuilder'
  import ReactionBodyBuilder from '../postBuilders/ReactionBodyBuilder'
  import HeaderBodyBuilder from '../postBuilders/HeaderBodyBuilder'
  import ShareBodyBuilder from '../postBuilders/ShareBodyBuilder'
  import PostCommentsBundler from './PostCommentsBundler'
  import Post from '../Post'
  import CommentPost from '../CommentPost'
  import SinglePostSkeleton from '../skeletonBuilders/SinglePostSkeleton'
  import Navigation from '../../mobile/root/Navigation'
  import CommentPop from '../popupBuilders/CommentPop'

    export default {
      name    		: "ViewPostBodyBuilder",
      components 	: {
      	MediaBodySwitch,
      	DeletedBodyBuilder,
      	TextBodyBuilder,
      	ReactionBodyBuilder,
      	HeaderBodyBuilder,
      	ShareBodyBuilder,
        PostCommentsBundler,
      	Post,
        SinglePostSkeleton,
        Navigation,
        CommentPop,
        CommentPost
      },
      data    		: () => ({
        screen : globs.app.isMobile,
        id     : null,
        Post   : null,
        show   : false,
        header : 'Add Your Comment',
      }),
      computed  : {
        ...mapGetters("posts", ['atComments', 'focusPost']),
      	mainPost : function(){
      		return this.focusPost;
      	},
      	Id : function(){
      		this.id = this.$route.params.id
      		return this.id
      	},
      },
      methods  	: {
      	...mapActions("posts", ['setSinglePost', 'getSinglePost']),
      	back : function(){
      		window.history.back();
      	},
        toggleShow : function(){
          this.show = !this.show;
        },
      },
      created(){
        this.mainPost == null ? this.getSinglePost(this.Id) : this.setSinglePost(this.mainPost)
      }

    };
</script>

<style scoped>

  @media only screen and (min-width : 700px){

    .desk-media-wrap{
      position: fixed;
      width: 44.4%;
      top: 75px;
      left: 25%;
      bottom: 10px;
      border: .04em solid red;
    }

    .comments-viewport-main{
      position: fixed;
      width: 30%;
      top : 75px;
      right: 10px;
      bottom: 10px;
      border: .04em solid rgba(211, 211, 211, .175);
      overflow-y: auto;
    }

  }

  @media only screen and (max-width: 700px){
    .comments-viewport{
      padding: 0;
      margin: 0;
    }
  }

</style>
