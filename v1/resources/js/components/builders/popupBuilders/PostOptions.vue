<template>

	<div class="list-group">
		
		<!-- Show Likers -->
		<a class="list-group-item b-under">

			<router-link :to="{ name : 'list', params : { username : post.getBasic().handle, id : post.getPost().id, type : 'likers' } }">

				<div class="media">
					
					<div class="self-align-center">
					
					<svg-vue icon="heart" class="app-icon"></svg-vue>

					</div>
					<div class="media-body ml-2">

						<span class="app-bolder-text">
							Likers
						</span>

					</div>

				</div>

			</router-link>

		</a>

		<!-- Show Commenters -->
		<a class="list-group-item b-under">
			
			<router-link :to="{ name : 'list', params : { username : post.getBasic().handle, id : post.getPost().id, type : 'commenters' } }">
				
				<div class="media">
					
					<div class="self-align-center">
					
					<svg-vue icon="comment" class="app-icon"></svg-vue>

					</div>

					<div class="media-body ml-2">
						
						<span class="app-bolder-text">
							Commenters
						</span>

					</div>

				</div>

			</router-link>

		</a>

		<!-- Go To Full Post Page -->
		<a class="list-group-item b-under">

			<router-link :to="{ name : 'comment', params : {username : post.getBasic().handle, id : post.getPost().id} }" >
				
				<div class="media">
					
					<div class="self-align-center">
					
					 <i class="fa fa-external-link app-fa"></i>

					</div>

					<div class="media-body ml-2">
						
						<span class="app-bolder-text">
							Go To Post
						</span>

					</div>

				</div>

			</router-link>

	  </a>
		<!-- Show Follow Button And Block Button -->
		<div class="list-group-item b-under">
			
			<div class="media">
				
				<div class="user-image align-self-center">
				 
				 <img class="rounded-circle" width="40" height="40" :src="'' + post.getImgs().profile" />
				
				</div>

				<div class="media-body ml-2">
					
					<div class="list-group">
						<div class="list-group-item no-border p-1">

							<FollowButton :user="post" :classes="'btn-block input-block-level btn-sm'"></FollowButton>
						
						</div>
						<div class="list-group-item no-border p-1">
							Block Button
						</div>
					</div>

				</div>

			</div>

		</div>

	</div>
	
</template>

<script>

	import FollowButton from '../userBuilders/FollowButton'

	export default {

		name 			 : "PostOptions",
		components : {
			FollowButton
		},
		data 			 : function(){
			return {};
		},
		props 		 : ['post'],

	};
	
</script>

<style scoped>
	
	.b-under{

		border: 0;
		border-bottom: .05em solid rgba(211, 211, 211, .6);

	}

	.no-border{
		border : 0;
	}

	.media{
		width: 100%;
	}

</style>