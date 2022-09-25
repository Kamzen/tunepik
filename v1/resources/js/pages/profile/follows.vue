<template>

	  <div class="follows-wrapper">

	  	<div class="card mt-1">
	  		
	  		<div class="" v-if="screen">
	  		
		  		<Navigation >

			  		<div class="media-body ml-2 align-self-center">
			  		
			  			<center>

			  				<span class="app-max-text">
			  					{{ Header }}
			  				</span>

			  			</center>

			  		</div>
			  		<div class="media-right align-self-center">
			  			
			  			<img class="rounded-circle" height="35" width="35" :src="'' + profile.model.getImgs().profile" />

			  		</div>

			  	</Navigation>

			  	<div class="space-large"></div>
			  	<div class="space-medium"></div>

		  	</div>
	  		<div class="card-header" v-else>
	  			
	  			<div class="media">
	  				
	  				<div class="media-left align-self-center">
	  					
	  					<h3>
	  						{{ Header }}
	  					</h3>

	  				</div>
	  				<div class="media-body"></div>
	  				<div class="media-right align-self-center">
	  					
	  					<img class="rounded-circle" height="40" width="40" :src="'' + profile.model.getImgs().profile" />

	  				</div>

	  			</div> <!--  END OF MEDIA -->

	  		</div> <!-- END OF CARD HEADER -->

	  		<div class="card-body">
	  			
	  			<template v-if="follows.loading">
	  			
	  					<UserListSkeleton></UserListSkeleton>

	  			</template>
	  			<template v-else>
	  					
	  					<UserListBundler :users="follows.users" :message="follows.message" v-if="!follows.error"></UserListBundler>
	  					<div class="" v-else>
	  						
	  						<div class="app-deleted-post grey-matter">
	  							
	  							<center>
	  								<span class="app-post-text">
	  									{{ follows.message }}
	  								</span>
	  							</center>

	  						</div>

	  					</div>

	  			</template>

	  		</div>

	  	</div> <!-- END OF CARD -->

	  	<!-- V_ELSE FOR DESKTOP ELSE -->

	  	<div class="visible-xs space-large"></div>
	  	<div class="visible-xs space-medium"></div>

	  	<!-- Show Following Lists -->

	  	
	  </div>


</template>

<script>

		import { mapGetters, mapActions } from 'vuex'
		import globs from '../../tunepik/attack.js'
		import Navigation from '../../components/mobile/root/Navigation'
		import PostLists from '../../components/builders/listBuilders/PostLists'
		import UserListSkeleton from '../../components/builders/skeletonBuilders/UserListSkeleton'
		import UserListBundler from '../../components/builders/userBuilders/UserListBundler'

		export default {

			name 			: "Lists",
			components : {

				Navigation,
				PostLists,
				UserListSkeleton,
				UserListBundler

			},
			data 			: function(){
				return {

					screen : globs.app.isMobile,
					type : '',
					username : '',
					header   : '',
					url 		 : ''

				};
			},
			computed : {
				context : function(){

					this.type = this.$route.params.type;
					return this.type;

				},
				Username : function(){

					this.username = this.$route.params.username;
					return this.username;

				},
				Header : function(){

				 switch (this.context) {

				 	case 'followers'  :
				 			this.header = 'Followers';
				 		break;

				 	case 'following'  :
				 			this.header = 'Following';
				 		break;
				 	default:
				 			this.header = 'Default';
				 		break;
				 }

				 return this.header;

			},
			Url : function(){

					this.url = `${globs.api}follow/${this.context}`
					return this.url;

				},
				...mapGetters("profile", ['follows', 'profile'])

			},
			methods 		: {

					...mapActions("profile", ['getFollowsUsers']),

			},
			created(){

				this.getFollowsUsers(this.Url);

			},
			watch : {

				'$route.params.type'(newType, oldType){

					this.context = newType;
					this.getFollowsUsers(this.Url);

				}

			}
			

		};
	
</script>

<style scoped>

		@media only screen and (max-width: 700px){

			.follows-wrapper{

				z-index: 9999 !important;
				position: fixed;
				top : 0;
				bottom: 0;
				left: 0;
				right: 0;
				width: 100%;
				height: 100%;
				overflow-y: auto;
				background-color: #fff;

			}

			.card-body{
				padding: 0;
			}

		}
	
</style>