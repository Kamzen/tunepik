<template>

	<div class="wrapper">

		<!-- <PostsLayoutTab :headerText="'Grid'" :user="profile.model" v-if="type == 'all'"></PostsLayoutTab> -->
		<div class="media sub-header pt-2 pb-2" v-if="type != 'all'">
			
			<div class="media-left align-self-center ml-4">

				<router-link :to="{ name : 'profile', params : { username : profile.model.getBasic().handle } }" class="list-btn user-nav-btn">

 	 	 	 	 <svg-vue icon="list" class="app-icon action-nav-icon"></svg-vue>

 	 	 	 	</router-link>
				
			</div>
			<div class="media-body align-self-center mr-5">
				<center>
					<span class="app-bolder-text">
						{{ type }}s
					</span>
				</center>
			</div>

		</div>
		
		<GridBundler :posts="grid.posts" :loading="grid.loading" :error="grid.error" :message="grid.message"></GridBundler>

	</div>
	
</template>

<script>

		import { mapGetters, mapActions } from 'vuex'
		import GridBundler from '../../../components/builders/postBuilders/GridBundler'
		import PostsLayoutTab from '../../../components/builders/profileBuilders/PostsLayoutTab'

		export default {

			name 				: "Grid",
			scrollToTop : false,
			data        : function(){

				return {

					paramsType : ''

				}

			},
			components  : {

				PostsLayoutTab,
				GridBundler

			},
			computed 		: {

				...mapGetters("profile", ['grid', 'profile', 'posts']),
				type 			: function(){

					return this.$route.params.type;

				}

			},
			methods 		: {

				...mapActions("profile", ['makeGrid', 'getUserPosts'])

			},
			mounted  : function(){

					this.makeGrid(this.type);

			},
			watch : {

				'$route.params.type'(newVal, oldVal){

					// this.paramsType = newVal;

					this.makeGrid(this.type);

				},

			}


		};
	
</script>

<style scoped>

  .sub-header {

  	border : .05em solid rgba(211, 211, 211, .4);

  }
	
</style>