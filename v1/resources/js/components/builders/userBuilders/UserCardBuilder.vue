<template>

		 
		<div class="user-card-wrapper mt-1">

			<!-- User Image! -->
				<div class="user-image-wrap pt-2">
				   
				   <center>
				   	 
				   	 <img height="60" width="60" class="rounded-circle" :src="'' + user.getImgs().profile" />

				   	  <div class="user-name-wrap mt-1">
				   	  	
				   	  	<router-link :to="{ name : 'profile', params : { username : user.getBasic().handle } }" >
				   	  		
				   	  		<span class="app-bold-text">
				   	  			{{ user.getBasic().name }}
				   	  		</span>

				   	  	</router-link>

				   	  </div>
				   	  <div class="user-bio">
				   	  	
				   	  	<span class="app-grey-text-sm">{{	user.getInfo().bio }}</span>

				   	  </div>

				   </center>

				   <div class="space-small"></div>

				   <!-- Follow Button Place -->
				   <div class="user-follow-btn" style="width: 100%;">
				   	
				   		<FollowButton :user="user" :classes="''"></FollowButton>

				   </div>

				   <div class="space-medium"></div>
				   
				   <!-- User Stats -->
				   <div class="user-stats-wrapper m-0 grey-matter">
				   	
				   		<table class="table">
				   				<tr>
				   					<td class="">
				   						
				   						<center>
				   							
				   							<span class="icon-wrap">
				   							
					   							<svg-vue icon="gallery" class="app-icon user-list-icon"></svg-vue>

					   						</span>
					   						<br />
					   						<span class="app-grey-text-lg">
					   							{{ user.getMedia().images }}
					   						</span>

				   						</center>

				   					</td>
				   					<td class="">
				   						
				   						<center>
				   							
				   							<span class="icon-wrap">
				   							
					   							<svg-vue icon="video" class="app-icon user-list-icon"></svg-vue>

					   						</span>

					   						<br />

					   						<span class="app-grey-text-lg">
					   							{{ user.getMedia().videos }}
					   						</span>

				   						</center>

				   					</td>
				   					<td class="">
				   						
				   						<center>
				   							<span class="icon-wrap">
				   							
					   							<svg-vue icon="audio" class="app-icon user-list-icon"></svg-vue>

					   						</span>

					   						<br />
					   						<span class="app-grey-text-lg">
					   							{{ user.getMedia().audios }}
					   						</span>

				   						</center>

				   					</td>
				   				</tr>
				   		</table>

				   </div>

				</div>


		</div>
       
</template>

<script>

  import globs from '../../../tunepik/attack.js'
  import FollowButton from './FollowButton'

    export default {

        name       : "UserCardBuilder",
        components : {

        	FollowButton

        },
        data       : () => {

          return {

            screen : globs.app.isMobile

          }

        },
        props : ['user']

    };
</script>

<style scoped>

		.user-card-wrapper{
			  width  : 200px;
			  height : 260px;
			  /*border : .05em solid lightgrey;*/
			  -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .175);
        box-shadow: 0 1px 2px rgba(0, 0, 0, .175);
		}

		.user-list-icon{

			width  : 18px;
			height : 18px;

		}
		.user-bio{
			width : 95%;
			height : 36px;
			/*max-height : 35px;*/
			overflow : hidden;
		}

</style>
