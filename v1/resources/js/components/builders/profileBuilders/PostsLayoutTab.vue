<template>

		<div class="app-profile-nav mt-1">
		 	<div class="action-profile-nav pb-1">
		 	 	  <center>
		 	 	  	<span class="app-feed-context-text app-grey-text-lg">{{ headerText }}</span>
		 	 	  </center>
		 	 <table class="app-profile-nav-table">
		 	 	 <tr>
		 	 	 	 <td class="app-tab app-profile-tab list-tab">
		 	 	 	 	 <center>
		 	 	 	 	 	 <router-link :to="{ name : tab.list }" class="list-btn user-nav-btn">

		 	 	 	 	 	 	 <svg-vue icon="list" class="app-icon action-nav-icon"></svg-vue>

		 	 	 	 	 	 	</router-link>
		 	 	 	 	 </center>
		 	 	 	 </td>
		 	 	 	 <td class="app-tab app-profile-tab grid-tab">
		 	 	 	 	 <center>
		 	 	 	 	 	<router-link :to="{ name : tab.grid }" class="grid-btn user-nav-btn">

		 	 	 	 	 		<svg-vue icon="grid" class="app-icon action-nav-icon"></svg-vue>

		 	 	 	 	 	</router-link>
		 	 	 	 	 </center>
		 	 	 	 </td>
		 	 	 	 <td class="app-tab app-profile-tab saved-tab">
		 	 	 	 	 <center>
		 	 	 	 	 	<router-link :to="{ name : tab.liked }" class="saved-btn user-nav-btn">

		 	 	 	 	 		<svg-vue icon="heart" class="app-icon action-nav-icon"></svg-vue>

		 	 	 	 	 	</router-link>
		 	 	 	 	 </center>
		 	 	 	 </td>
		 	 	 </tr>
		 	 </table>
		 	</div>
		 </div>
	
</template>

<script>

		export default {

			  name 	:    "PostsLayoutTab",
			  props :   ['headerText', 'user'],
		  	computed : {
		  		username : function(){

		  			return this.$route.params.username;

		  		},
		  		tab : function(){

		  			return {

		  				list 	: 'profile',
		  				grid 	: 'grid',
		  				liked : 'liked'

		  			};

		  		}

		  	}

		};
	
</script>


<style scoped>

	@media only screen and (min-width: 700px){

  	.action-profile-nav{

  		background-color: #fff;
  		border: .05em solid rgba(211, 211, 211, .5);
  		box-shadow: 0 .5px 1px 0 rgba(0, 0, 0, .175)

  	}

  	.col-lg-4{

  		background-color: #fff;

  	}

  	.row{
  		padding-right :15px;
  	}

  }

   @media only screen and (max-width: 700px){

  	.action-profile-nav{

  		background-color: #fff;
  		border: .05em solid rgba(211, 211, 211, .5);

  	}

  	.action-nav-icon{

  		width: 20px;
  		height: 20px;

  	}

  }
	
</style>