<template>
  
  <div class="root-element">

  	<template v-if="screen">
  		

  		<div class="main-show">

  		 	<div class="space-large" ></div>
  		  <div class="space-medium" ></div>
  			
  			<ViewPostBodyBuilder ></ViewPostBodyBuilder>

  		</div>


  	</template>
  	<template v-else>
  		

		  	<div class="space-large" ></div>
		  	<div class="space-large" ></div>

		  	<div class="space-medium"></div>

		  	<div class="main-show">
		  			
		  			<ViewPostBodyBuilder ></ViewPostBodyBuilder>

		  	</div>

  	</template>

  </div>

</template>

<script>

 import globs from '../../tunepik/attack.js'
 import ViewPostBodyBuilder from '../../components/builders/commentBuilders/ViewPostBodyBuilder'

export default {
	name 				: 'ViewPost',
	scrollToTop : false,
	components  : {

		ViewPostBodyBuilder

	},
	data 				: function () {
			
			return {

				screen : globs.app.isMobile

			}

	},
  middleware: 'auth',
  methods : {

  	back : function(){

  		window.history.back();

  	},

  }
  /*metaInfo () {
    return { title: this.$t('home') }
  }*/
};
</script>

<style scoped>

	.top-nav-icon{
		width 	: 30px;
		height 	: 30px;
	}
	.navbar{
		box-shadow : 0 0 0 0 transparent;

	}
	.view-comment-nav{

		border-bottom : .05em solid rgba(211, 211, 211, .4);
		height : 50px;

	}

</style>
