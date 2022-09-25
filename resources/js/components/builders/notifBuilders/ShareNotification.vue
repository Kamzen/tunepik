<template>

	<div class="media">

		<div class="user-img-wrapper align-self-start">	
	 	  <Picture :height="35" :width="35" :user="notification"></Picture>
	 </div>

		<div class="media-body align-self-center">
			<div class="media">
				
				<div class="media-body pl-2 align-self-center">
		 	 			
		 			<span class="app-grey-text-lg">
		 				<span class="app-bolder-text">{{ notification.getBasic().name }}</span>
		 				Has Shared Your Post
		 			</span>

		 		</div>
		 		<div class="media-right align-self-center">
				 	
				 		<Icon :icon="'share'" :height="16" :width="16"></Icon>

				 </div>

			</div>

			<div class="space-medium"></div>

			<!-- <ShareBodyBuilder :post="notification.getExtra().post"></ShareBodyBuilder> -->
			<router-link to="{ name : 'comment', params : { username : post.getBasic().handle,  type : post.getPost().type, id : post.getPost().id } }" >

				<a @click="MAIN_POST(post)">

					<Post :post="post" :comments="false" class="post-bg"></Post>

				</a>
				
			</router-link>

		</div>

	</div>
	
</template>

<script type="text/javascript">

	import { mapMutations } from 'vuex'
	import ShareBodyBuilder from '../postBuilders/ShareBodyBuilder'
	import Post from '../Post'
	
	export default {

		name : 'ShareNotification',
		props : ['notification'],
		components : {

			ShareBodyBuilder,
			Post

		},
		methods : {
			...mapMutations('posts', ['MAIN_POST'])
		},
		computed : {
			post : function(){ return this.notification.getExtra().post || {} }
		}

	};

</script>

<style type="text/css" scoped>
	
	.post-bg{
		background-color: rgba(211, 211, 211, .125);
		border-radius: 5px;
	}

</style>