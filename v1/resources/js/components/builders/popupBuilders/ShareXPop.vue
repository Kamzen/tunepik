<template>
	
	<div class="list-group">
		
		<a v-bind:href="whatsappUrl" class="list-group-item">
			
			<div class="media">
				
				<div class="media-left align-self-center">
					
					<i class="fab fa-whatsapp app-fa"></i>

				</div>
				<div class="media-body ml-2">
					
					<span class="app-bolder-text">Share to WhatsApp</span>

				</div>

			</div>

		</a>
		<a v-bind:href="twitterURL" class="list-group-item">
			
			<div class="media">
				
				<div class="media-left align-self-center">
					
					<i class="fab fa-twitter app-fa"></i>

				</div>
				<div class="media-body ml-2">
					
					<span class="app-bolder-text">Share to Twitter</span>

				</div>

			</div>

		</a>

	</div>

</template>

<script>

	import globs from '../../../tunepik/attack.js'

	export default {

		name 				: "ShareXPop",
		props 			: ['post'],
		computed 		: {

			whatsappUrl : function(){ return `https://api.whatsapp.com/send?text=${this.text} ${this.url}`; },

			twitterURL  : function(){ return `http://twitter.com/intent/tweet?url=${this.url}&text=${this.text}`; },

			text 				: function(){

				return `View ${this.post.getBasic().name}(@${this.post.getBasic().handle})'s Post On TunePik `;

			},
			url    : function(){

				return `${globs.url}${this.post.getBasic().handle}/${this.post.getPost().id}/`;

			}

		}

	};
	
</script>

<style scoped>


	.list-group-item{

		border : 0;
		border-bottom : .05em solid rgba(211, 211, 211, .5);

	}

	.fab{
		font-size: 10pt;
	}
	
</style>