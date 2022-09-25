<template>
  
  <div class="root-element">

  	<template v-if="screen">
  		
	  	<nav class="navbar fixed-top bg-white home-nav navbar-light">
	  		
	  		<div class="media" style="width : 100%">

	  			<div class="home-options-wrapper align-self-center mr-2">
	  		  
		  		  <span class="options-icon-wrapper">
		  		     
		  		     <svg-vue icon="menu" class="app-icon top-nav-icon"></svg-vue>

		  		  </span>

	  		  </div>
	  			
	  			<div class="media-body">
	  				
	  				<div class="navbar-brand" >
	  					
	  					TunePik

	  				</div>
	  				
	  			</div>

	  			<div class="align-self-center topnav-icon-round skeleton-shimmer">

	  				<center>
	  					<router-link :to="{ name : 'search' }">
		  					<svg-vue icon="search" class="app-icon top-nav-icon"></svg-vue>
		  				</router-link>
	  				</center>
	  				
	  			</div>

	  		</div>

	  	</nav>

  	</template>

  	<div class="space-large" ></div>
  	<div class="space-medium visible-xs"></div>
  	<div class="space-large visible-lg"></div>

  	<!-- <div class="space-large d-sm-none d-lg-block"></div> -->

  	<div class="main-show row">
  		
  		<div class="col-lg-7">

  			<div class="space-medium visible-lg"></div>
  			
  			<FeedPosts ></FeedPosts>

  		</div>

  		<!-- Show Only In Desktops -->
  		<template v-if="!screen">
  			
  			<div class="col-lg-5">
  				
  				<div class="space-medium"></div>

  				<!-- Show The Right Side Views -->
  				<RightSideBuilder ></RightSideBuilder>
  			
  		  </div>

  		</template>

  	</div>

  </div>

</template>

<script>

 import globs from '../tunepik/attack.js'
 import RightSideBuilder from '../components/desktop/homeComp/RightSideBuilder'

 export default {
	name 				: 'Home',
	components 	: {

		RightSideBuilder

	},
	data 				: function () {
			
			return {

				screen : globs.app.isMobile

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

    border-radius: 15px;
    padding: 2px;
    width: 20%;
    /*-webkit-box-shadow: 0 .5px 1px rgba(0, 0, 0, .175);
    box-shadow: 0 .5px 1px rgba(0, 0, 0, .175);*/
    position: relative;
    top: -3px;

  }

	.top-nav-icon{
		width 	: 30px;
		height 	: 30px;
	}
	.navbar{
		box-shadow : 0 .5px 1px 0 rgba(211, 211, 211, .4);

	}
	.home-nav{
		height : 50px;

	}

</style>
