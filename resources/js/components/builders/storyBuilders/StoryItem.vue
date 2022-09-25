<template>

	<div class="wrapper">
		
		<Navigation>
			
			<div class="media-body align-self-center">
				
				<div class="media">
					<Picture :user="user" :width="30" :height="30" class="align-self-center"></Picture>
					<div class="media-body pl-2">
						<user-name :user="user"></user-name>
					</div>
				</div>

			</div>
			<div class="media-right align-self-center">
				<span class="app-post-text">{{ time }}</span>
			</div>

		</Navigation>
		<div class="space-large"></div>
		<div class="space-large"></div>
		
		<div class="story-wrapper">
			
			<text-body-builder :text="storyItem.getPost().text" v-if="storyItem.getPost().type == 'text'"></text-body-builder>
			<media-body-switch :post="storyItem" v-else></media-body-switch>

		</div>


	</div>
	
</template>

<script type="text/javascript">

	import { mapGetters, mapActions, mapMutations } from 'vuex'
	import Navigation from '../../mobile/root/Navigation'
	import TextBodyBuilder from '../postBuilders/TextBodyBuilder'
	import MediaBodySwitch from '../postBuilders/MediaBodySwitch'
	
	export default {

		name 	: "StoryItem",
		data 	: () => ({
			time : 0,
			rootInterval : null,
			subInterval : null,
			userStoriesIndex : 0
		}),
		components :{
			Navigation,
			TextBodyBuilder,
			MediaBodySwitch
		},
		computed : {
			...mapGetters("story", ['view', 'stories']),
			story : function(){
				if(this.stories.stories.length > 0 && this.view.index <= this.stories.stories.length - 1) return this.stories.stories[this.view.index]
					else {

						this.SET_VIEW_INDEX({ index : 0 })
						history.back() // If Reached End Of Stories, Go Back To The Last Visited Page
						return 0

					}
			},
			user : function(){
				console.log(this.story.user)
				return this.story.user || {}
			},
			userStories : function(){
				console.log(this.story.userStories)
				return this.story.userStories || []
			},
			storyItem : function(){
				console.log(this.userStories[this.userStoriesIndex])
				return /*this.userStories.length > ? */this.userStories[this.userStoriesIndex] || {}
			}
		},
		methods : {
			...mapMutations("story", ['SET_VIEW_INDEX']),
			subCounter : function(){

				this.subInterval = setInterval(() => {

					this.time += 1 // Increase Time, Will Show The Story For 30sec

					if(this.time == 29) { 

							if(this.userStoriesIndex <= this.userStories.length - 1){

								this.userStoriesIndex += 1 // Increase Index To Traverse Through All User's Stories
								this.time = 0 // Reset The Time For The Next Story

							}else{
								this.userStoriesIndex = 0
								this.SET_VIEW_INDEX({ index : this.view.index + 1 })
							}
					}

				}, 1000)

			}
		},
		mounted : function(){
			console.log(this.story)
			console.log(this.userStories)
			console.log(this.storyItem.getPost())
			this.$nextTick(() => {
				this.subCounter()
			})
		}
	};

</script>

<style type="text/css" scoped>
	
	@media only screen and (max-width: 700px){

		 .wrapper{
				z-index: 9999 !important;
				position: fixed;
				top : 0;
				bottom: 0;
				left: 0;
				right: 0;
				width: 100%;
				height: 100%;
				overflow-y: auto;
				/*background-color: #fff;*/

			}

		}

</style>