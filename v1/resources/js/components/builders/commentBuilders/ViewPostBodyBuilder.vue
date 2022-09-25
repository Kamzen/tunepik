<template>

	<div class="row" style="">
       <div class="col-lg-8 post-viewport-wrapper-lg" style="">


         <div class="post-viewport">
          <a class="app-modal-lg-btn btn btn-sm" v-on:click="back()" v-if="!screen">

          	<svg-vue icon="back" class="app-icon"></svg-vue>

           </a>

              <div class="" v-if="atComments.postLoading">
                
                <PostSkeleton></PostSkeleton>

              </div>
              <div class="" v-else>

              	<template v-if="screen">

                  <!-- NAVIGATION -->
                  <Navigation>
                    
                    <div class="media-body pl-3">
                        
                        <span class="app-max-text">
                          Full Post
                        </span>
                      
                    </div>

                    <div class="align-self-center">

                      <button v-on:click="toggleShow()" class="btn btn-info btn-sm">
                        
                        Add Comment

                      </button>
                      
                    </div>

                  </Navigation>

                  <!-- ADD COMMENT POP OUT -->

                  <PopUpWindow :headerText="header" :show="show">
                    
                      <CommentPop :post="atComments.post"></CommentPop>

                  </PopUpWindow>

			           	<Post :post="atComments.post" :comments="false"></Post>

			           </template>
			           <template v-else>

			           		<MediaBodySwitch :post="atComments.post"></MediaBodySwitch>

			           </template>


              </div>

           <!-- Show Full Post Here For Small Screens -->



         </div>

       </div>
       <div class="col-lg-4 comments-viewport-main darkmode-wrapper">

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

              <TextBodyBuilder :post="atComments.post"></TextBodyBuilder>

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
  import PostSkeleton from '../skeletonBuilders/PostSkeleton'
  import Navigation from '../../mobile/root/Navigation'
  import PopUpWindow from '../popupBuilders/PopUpWindow'
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
          PostSkeleton,
          Navigation,
          PopUpWindow,
          CommentPop

        },
        data    		: () => {

          return {

            screen : globs.app.isMobile,
            id 		 : null,
            /*username : this.$route.params.username,*/
            Post   : null,
            show   : false,
            header : 'Add Your Comment',

          }

        },

        computed  : {

        	mainPost : function(){

        		this.Post = this.post;

        		return this.Post;

        	},
        	Id : function(){

        		this.id = this.$route.params.id

        		return this.id
        	},
        	...mapGetters("posts", ['atComments'])

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
        props : ['post'],
        created(){

        	/*
        		Check If Prop For :post Was Passed
        	*/
        	if(this.mainPost == null){

        		this.getSinglePost(this.Id);

        	}else{

        		this.setSinglePost(this.mainPost)

        	}

        }

    }
</script>

<style scoped>

  @media only screen and (min-width : 700px){

  	.row{

  		border : .05em solid rgba(211, 211, 211, .4);

  	}
  	.col-lg-4{

  		border-left : .05em solid rgba(211, 211, 211, .4);

  	}

  }

</style>
