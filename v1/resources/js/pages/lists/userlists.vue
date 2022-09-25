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
	  		
	  		<PostLists :url="Url"></PostLists>

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
			components : {

				Navigation,
				PostLists

			},
			data 			: function(){
				return {

					screen : globs.app.isMobile,
					type : '',
					id 	 : '',
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
				Id   : function(){

					this.id  = this.$route.params.id;
					return this.id;

				},
				Username : function(){

					this.username = this.$route.params.username;
					return this.username;

				},
				Header : function(){

				 switch (this.context) {

				 	case 'likers'     :
				 			this.header = 'Likers';
				 		break;

				 	case 'commenters' :
				 			this.header = 'Commenters';
				 	  break;

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

				switch (this.context) {
					case 'likers'				:
					case 'commenters' 	:
							this.url = `${globs.api}react/view/${this.context}/${this.Id}/?type=post`;
						break;

					case 'followers'		:
					case 'following'		:
							this.url = `${globs.api}follow/${this.context}/${this.Id}`;
						break;
					default:
							this.url = '';
						break;
				}

				return this.url;

			}

			},
			

		};
	
</script>

<style scoped>
	
</style>