<template>

	<div class="wrapper">
		<!-- 
		<div class="row">
					
			<div class="col-lg-8"> -->

				<PostsLayoutTab :headerText="header" :user="user"></PostsLayoutTab>

			   <transition name="fade" mode="out-in">
	        	<router-view />
	       </transition>

			<!-- </div>
			<div class="col-lg-4 mt-1" v-if="!screen"></div>

		</div> -->

	</div>
	
</template>

<script>

  import {mapGetters, mapActions} from 'vuex'
  import globs from '../../../tunepik/attack.js'
  import PostsLayoutTab from './PostsLayoutTab'
  
  

  export default {

  	name : "UserExtendedView",
  	data 	: () => ({
  		header : '',
      screen : globs.app.isMobile
  	}),
  	components :{
      PostsLayoutTab
  	},
  	props : ['user'],
  	watch : {

  		'$route.path' : function(currentPath){

  			switch (currentPath) {
  				case `/${this.user.getBasic().handle}/`:

  						this.header = 'list'

  					break;

  				case `/${this.user.getBasic().handle}/grid/all` :

  						this.header = 'grid'

  					break;

  				case `/${this.user.getBasic().handle}/liked` :

  						this.header = 'liked'

  				default:
  					// statements_def
  					break;
  			}

  		}

  	}

  };
	

</script>

<style scoped>

</style>