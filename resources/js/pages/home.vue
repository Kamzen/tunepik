<template>
  
  <div class="root-element">

  	<template v-if="screen">
  		
	  	<HeadNavbar></HeadNavbar>

  	</template>

  	<div class="space-large visible-xs" ></div>
  	<div class="space-medium visible-xs"></div>
  	<!-- <div class="space-large visible-lg"></div> -->

  	<!-- <div class="space-large d-sm-none d-lg-block"></div> -->

  	<div class="main-show row">
  		
  		<div class="col-lg-7">

  			<!-- <div class="space-medium visible-lg"></div> -->
    			<story-header v-if="screen">
            <story-slide-bundler :url="storyURL">
              <div class="media-left align-self-center p-2">
                <add-story></add-story>
              </div>
            </story-slide-bundler>   
          </story-header>
    			
    			<feed-posts class="feed-posts"></feed-posts>
    		</div>

  		<!-- Show Only In Desktops -->
  		<template v-if="!screen">
  			
  			<div class="col-lg-5">
  				
  				<div class="space-medium"></div>

  				<!-- Show The Right Side Views -->
  				<right-side-builder ></right-side-builder>
  			
  		  </div>

  		</template>

  	</div>

  </div>

</template>

<script>

 import globs from '../tunepik/attack.js'
 import RightSideBuilder from '../components/desktop/homeComp/RightSideBuilder'
 import HeadNavbar from '../components/mobile/HeadNavbar'
 import StorySlideBundler from '../components/builders/storyBuilders/StorySlideBundler'
 import StoryHeader from '../components/builders/storyBuilders/StoryHeader'
 import AddStory from '../components/builders/storyBuilders/AddStory'
 import { mapGetters, mapActions, mapMutations } from 'vuex'

 export default {
	name 				: 'Home',
	scrollToTop : false,
	components 	: {
		RightSideBuilder,
		HeadNavbar,
		StorySlideBundler,
		AddStory,
    StoryHeader
	},
	data 				: () => ({
		screen : globs.app.isMobile,
		imgs   : '*.png, *.jpeg, *.jpg ',
		storyURL : '/api/stories/all'
	}),
	methods  : {
		...mapMutations("files", ['isSet', 'chosen', 'isFile', 'done']),
	},
	computed : {
		...mapGetters("files", ['image']),
		...mapGetters("auth", ['model'])
	},
	watch  : {

		'image.src' : function(val){

			this.isFile(val != "");
		 	this.done(val == "")
			this.isSet(val != "");
			this.chosen(val != "");

			this.$router.push({ name : 'createPost' });

		}

	},
  middleware: 'auth',
  metaInfo () {
    return { title: this.$t('home') }
  }
};
</script>

<style scoped>

  .topnav-icon-round{

    border-radius: 20px;
    /*-webkit-box-shadow: 0 .5px 1px rgba(0, 0, 0, .175);
    box-shadow: 0 .5px 1px rgba(0, 0, 0, .175);*/

  }

  
  @media only screen and (min-width: 700px){
    .row{
      /*margin-left: -15px;
      margin-right: -80px;*/
      margin-right: -20%;
      margin-left: -2%;
     }

     .col-lg-7{
      padding: 0;
     }

     /*.feed-posts{
      position: relative;
      left: 1%;

     }*/

     /*.col-lg-5{
     	margin-left: 40px;
     }*/

  }

  .app-fa{

  	width 	: 24px;
		height 	: 24px;

  }
	.top-nav-icon{
		width 	: 30px;
		height 	: 30px;
	}
	.navbar{
		box-shadow : 0 .5px 1px 0 rgba(211, 211, 211, .4);

	}
	.home-nav{
		height : 45px;

	}

</style>
