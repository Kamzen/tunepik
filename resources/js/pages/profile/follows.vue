<template>

	  <div class="follows-wrapper wrapper">

	  	<div class="card mt-1 no-border">
	  		
	  		<div class="" v-if="screen">
	  		
		  		<Navigation >

			  		<div class="media-body align-self-center">

			  				<span class="app-max-text">
			  					{{ Header }}
			  				</span>
			  				<span class="profile-user-handle app-post-text" style="display: block;line-height: 1;">
                for (@{{ profile.model.getBasic().handle }})
              </span>

			  		</div>
			  		<div class="media-right align-self-center">
			  			
			  			<a @click="grid = !grid">
			  				
			  				<Icon :icon="grid ? 'list' : 'grid'" :width="24" :height="24"></Icon>

			  			</a>

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
	  					
	  					<a @click="grid = !grid">
			  				
			  				<Icon :icon="grid ? 'list' : 'grid'" :width="24" :height="24"></Icon>

			  			</a>

	  				</div>

	  			</div> <!--  END OF MEDIA -->

	  		</div> <!-- END OF CARD HEADER -->

	  		<div class="card-body pt-0">
	  			
	  			<template v-if="follows.loading">
	  		
	  					<GridSkeleton :cols="2" v-if="grid"></GridSkeleton>
	  					<UserListSkeleton v-else></UserListSkeleton>

	  			</template>
	  			<template v-else>
	  					
	  					<UserListBundler :users="follows.users" :message="follows.message" v-if="!follows.error" :showGrid="grid"></UserListBundler>
	  					<div class="" v-else>
	  						
	  						<div class="app-deleted-post grey-matter">
	  							
	  							<center>
	  								<span class="app-small-text">
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
		import GridSkeleton from '../../components/builders/skeletonBuilders/GridSkeleton'
		import UserListBundler from '../../components/builders/userBuilders/UserListBundler'


		export default {

			name 			: "Lists",
			scrollToTop : false,
			components : {

				Navigation,
				PostLists,
				UserListSkeleton,
				GridSkeleton,
				UserListBundler

			},
			data 			: function(){
				return {

					screen : globs.app.isMobile,
					type : '',
					grid     : true,

				};
			},
			computed : {

				context : function(){

					return this.$route.params.type || 'followers'

				},
				Header : function(){

				 switch (this.context) {

				 	case 'followers'  :
				 			return 'Followers';
				 		break;

				 	case 'following'  :
				 			return 'Following';
				 		break;

				 	default:
				 			return 'Default';
				 		break;
				 }

			},
			url : function(){

					return `${globs.api}follow/${this.context}/${this.profile.model.getBasic().id}/`

			},
			...mapGetters("profile", ['follows', 'profile'])

			},
			methods 		: {

					...mapActions("profile", ['getFollowsUsers']),

			},
			created(){

				this.getFollowsUsers({url : this.url});

			},
			watch : {

				'$route.params.type'(newType, oldType){

					this.getFollowsUsers({url : this.url});

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

			}

			.card-body{
				padding: 0;
			}

			.card{

				box-shadow: 0 0 0 0 transparent;

			}

		}
	
</style>