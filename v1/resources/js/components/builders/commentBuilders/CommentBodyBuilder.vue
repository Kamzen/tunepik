<template>

	<!-- Wrapper -->
	<div class="app-comment-body mt-1">
		
		<div class="media">
		  
		  <!-- User Image -->

			<img class="rounded-circle" height="30" width="30" :src="'' + comment.getImgs().profile" />

			<div class="media-body feed-comment-body pl-1 m-1">

				<!-- User Name -->

				<router-link v-bind:to="{ name : 'profile', params : { username : comment.getBasic().handle } }">
					
					<span class="app-bold-text">
						{{ comment.getBasic().name }}
					</span>

				</router-link>

				<template v-if="comment.getPost().type == 'deleted'">
					
					<DeletedBodyBuilder :post="comment"></DeletedBodyBuilder>

				</template>
				<template v-else>
					
					<TextBodyBuilder :post="comment"></TextBodyBuilder>

				</template>

				<div class="comment-bottom-row">
					
					<!-- Show Time Of Comment And Comment Reaction Button -->

					<div class="media p-0 m-0" style="margin:0">
						
						<div class="media-body p-0">
							
							<span class="app-grey-text-sm">{{ comment.getPost().time }} {{ comment.getPost().date }}</span>

						</div>

						<!-- Show Reaction -->
						<a href="#" class="pr-1">
							
							<span class="comment-like-icon">
								
								<svg-vue icon="heartEmpty" class="app-icon comment-icon"></svg-vue>

							</span>

						</a>

					</div>

				</div>

			</div>

			<!-- Comment Options -->

			<div class="comment-options">
				
				<a href="#">
					
					<span class="comment-options-icon ">
						
						<svg-vue icon="arrowdown" class="app-icon comment-icon"></svg-vue>

					</span>

				</a>

			</div>

		</div>

	</div>
       
</template>

<script>

  import globs from '../../../tunepik/attack.js'
  import DeletedBodyBuilder from '../postBuilders/DeletedBodyBuilder'
  import TextBodyBuilder from '../postBuilders/TextBodyBuilder'

    export default {

        name    		: "CommentBodyBuilder",
        components 	: {

        	DeletedBodyBuilder,
        	TextBodyBuilder

        },
        data    		: () => {

          return {

            screen : globs.app.isMobile

          }

        },
        props 		: ['comment']

    };
</script>

<style scoped>

		.comment-icon{

			width : 15px;
			height : 15px;

		}
		.feed-comment-body{
    width: 100%;
    height: auto;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .175);
        box-shadow: 0 1px 2px rgba(0, 0, 0, .175);
    /*border: .05em solid rgba(211, 211, 211, .2);*/
  }

</style>
