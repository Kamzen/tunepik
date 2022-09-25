<template>

	  <div class="wrapper">

	  	<Navigation v-if="screen">
	  		
	  		<div class="media-body ml-2">
	  			<center>
	  				<span class="app-max-text">
	  					{{ Header }}
	  				</span>
	  			</center>
	  		</div>
	  		<div></div>

	  	</Navigation>
	  	<!-- V_ELSE FOR DESKTOP ELSE -->

	  	<div class="visible-xs space-large"></div>
	  	<div class="visible-xs space-medium"></div>

	  	<!-- Show Reaction Views Lists -->
	  	<template v-if="context == 'likers' || context == 'commenters'">
	  		
	  		<PostLists :url="url"></PostLists>

	  	</template>

	  	<!-- Show Following Lists -->
	  	<template v-else-if="context == 'followers' || context == 'following'"></template>

	  	
	  </div>


</template>

<script>

		import globs from '../../tunepik/attack.js'
		import Navigation from '../../components/mobile/root/Navigation'
		import PostLists from '../../components/builders/listBuilders/PostLists'

		export default {

			name 			: "Lists",
			scrollToTop : false,
			components : {

				Navigation,
				PostLists

			},
			data 			: () => ({
				screen : globs.app.isMobile,
			}),
			computed : {
				context : function(){

					return this.$route.params.type || 'likers'

				},
				id  : function(){

					return this.$route.params.id || 0

				},
				Username : function(){

					return this.$route.params.username || 'guest'

				},
				Header : function(){

				 switch (this.context) {

				 	case 'likers'     :
				 			return 'Likers'
				 		break;

				 	case 'commenters' :
				 			return 'Commenters'
				 	  break;

				 	case 'followers'  :
				 			return 'Followers'
				 		break;

				 	case 'following'  :
				 			return 'Following'
				 		break;

				 	default:
				 			return 'Default'
				 		break;
				 }

			},
			url : function(){

					switch (this.context) {

						case 'likers'				:
						case 'commenters' 	:

								return `${globs.api}react/view/${this.context}/${this.id}/?type=post`

							break;

						case 'followers'		:
						case 'following'		:

								return `${globs.api}follow/${this.context}/${this.id}/`

							break;

						default:
								return '';
							break;
					}

				}

			},
			

		};
	
</script>

<style scoped>
	
</style>