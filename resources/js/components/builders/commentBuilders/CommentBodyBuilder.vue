<template>

	<!-- Wrapper -->
	<div class="mt-2">
		
		<div class="media pl-2 pr-3">
		  
		  <!-- User Image -->

			<Picture :height="30" :width="30" :user="comment"></Picture>

			<div class="media-body pl-1 m-1">

				<!-- User Name -->

				<router-link style="display:inline-block" v-bind:to="{ name : 'profile', params : { username : comment.getBasic().handle } }">
					
					<span class="app-bold-text pl-2">
						{{ comment.getBasic().name }}
					</span>

				</router-link>

				<template v-if="comment.getPost().type == 'deleted'">
					
					<DeletedBodyBuilder :post="comment"></DeletedBodyBuilder>

				</template>
				<template v-else>
					
					<TextBodyBuilder style="display:inline-block" :text="comment.getPost().text"></TextBodyBuilder>

				</template>

				<MediaBodySwitch :post="comment" v-if="comment.getPost().type != 'deleted' && comment.getPost().type != 'text'"></MediaBodySwitch>

			</div>

			<!-- Comment Options -->

			<div class="media-right">
				
				<CommentReact :comment="comment"></CommentReact>

			</div>

		</div>

	</div>
       
</template>

<script>

  import globs from '../../../tunepik/attack.js'
  import DeletedBodyBuilder from '../postBuilders/DeletedBodyBuilder'
  import TextBodyBuilder from '../postBuilders/TextBodyBuilder'
  import MediaBodySwitch from '../postBuilders/MediaBodySwitch'
  import CommentReact from './CommentReact'

    export default {

        name    		: "CommentBodyBuilder",
        components 	: {

        	DeletedBodyBuilder,
        	TextBodyBuilder,
        	MediaBodySwitch,
        	CommentReact

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
    /*border: .05em solid rgba(211, 211, 211, .2);*/
  }

</style>
