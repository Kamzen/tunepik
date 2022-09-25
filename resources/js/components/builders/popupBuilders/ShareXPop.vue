<template>
	
	<div class="list-group">
		
		<a v-bind:href="whatsappUrl" class="list-group-item list-group-item-action">
			
			<div class="media">
				
				<div class="media-left align-self-center">
					
					<i class="fab fa-whatsapp app-fa"></i>

				</div>
				<div class="media-body ml-2">
					
					<span class="app-small-text">Share to WhatsApp</span>

				</div>

			</div>

		</a>
		<a v-bind:href="twitterURL" class="list-group-item list-group-item-action">
			
			<div class="media">
				
				<div class="media-left align-self-center">
					
					<i class="fab fa-twitter app-fa"></i>

				</div>
				<div class="media-body ml-2">
					
					<span class="app-small-text">Share to Twitter</span>

				</div>

			</div>

		</a>
		<a @click="share(shareData)" v-if="screen" class="list-group-item-action list-group-item">
			
			<div class="media">
				
				<div class="media-left align-self-center"></div>
				<div class="media-body ml-2">
					
					<span class="app-small-text">Share Via...</span>

				</div>

			</div>

		</a>

	</div>

</template>

<script>

	import globs from '../../../tunepik/attack.js'
	import { mapMutations } from 'vuex'

	export default {

		name 				: "ShareXPop",
		data 				: () => ({
			screen : globs.app.isMobile,
		}),
		props 			: ['post'],
		methods : {
			...mapMutations('tunepik', ['SNACK_BAR']),
			share : function(data){

				navigator.share(data).then(() => {

					this.SNACK_BAR({ isOpen : true, message : 'Shared Successfully', theme : 'info' })

				}).catch((e) => this.SNACK_BAR({ isOpen : true, message : `Sharing Failed, ${e}`, theme : 'info' }))

			}
		},
		computed 		: {

			whatsappUrl : function(){ return `https://api.whatsapp.com/send?text=${this.postText}\n${this.url}`; },

			twitterURL  : function(){ return `https://twitter.com/intent/tweet?url=${this.url}&text=${this.postText}`; },

			text 				: function(){

				return `View Full Post On TunePik `;

			},
			url    : function(){

				return `${globs.url}p/${this.post.getBasic().handle}/${this.post.getPost().type}/${this.post.getPost().id}/`;

			},
			postText : function(){

				 return `${this.post.getPost().text} - ${this.post.getBasic().name} (@${this.post.getBasic().handle}), ${this.post.getPost().now}... ${this.text}`

			},
			shareData : function(){
				return {
					text 		: this.postText,
					title   : 'TunePik',
					url 		: this.url
				}
			},

		}

	};
	
</script>

<style scoped>


	.list-group-item{

		border : 0;

	}

	.fab{
		font-size: 10pt;
	}
	
</style>