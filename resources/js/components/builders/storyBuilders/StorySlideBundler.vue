<template>

	<div class="wrapper">
			
			<story-slide-skeleton v-if="stories.loading"></story-slide-skeleton>
			<div class="story-body" v-else>

				<div class="media">
					
					<slot />
					<div class="media-body">
						
						<Flickity :options="options" ref="flickity">
							<!-- <story-face :user="model"></story-face>
							<story-face :user="model"></story-face>
							<story-face :user="model"></story-face>
							<story-face :user="model"></story-face>
							<story-face :user="model"></story-face>
							<story-face :user="model"></story-face>
							<story-face :user="model"></story-face>
							<story-bundler :stories="stories.stories"></story-bundler> -->

							<div class="wrap-story-items" v-for="(story, i) in stories.stories" :key="i">
						
								<router-link :to="{ name : 'stories', params : { username : story.user.getBasic().handle, id : story.user.getBasic().id } }">
									<a @click="SET_VIEW_INDEX({index : i})">
										<story-face :user="story.user"></story-face>
									</a>
								</router-link>

							</div>

						</Flickity>

					</div>

				</div>
				
			</div>

	</div>
	
</template>

<script type="text/javascript">

	import StorySlideSkeleton from '../skeletonBuilders/StorySlideSkeleton'
	import StoryFace from './StoryFace'
	import Flickity from 'vue-flickity'
	import { mapGetters, mapActions, mapMutations } from 'vuex'
	
	export default {

		name 	: "StorySlideBundler",
		data  : () => ({
			wrapper  : '.main-carousel',
      options : {

				freeScroll : false,
  	  	contain : true,
       	wrapAround : true,
       	autoPlay : 4000,
       	prevNextButtons : false,
       	pageDots : false

			}
		}),
		props : ['url'],
		components : {
			StorySlideSkeleton,
			StoryFace,
			Flickity,
		},
		computed : {
			...mapGetters("story", ['stories']),
			...mapGetters("auth", ['model'])
		},
		methods : {
			...mapActions('story', ['getStories']),
			...mapMutations('story', ['SET_VIEW_INDEX'])
		},
		mounted : function(){
			this.$nextTick(() => {
				this.getStories({url : this.url})
			})
		}

	};

</script>

<style type="text/css" scoped>

	.wrapper{
		border-bottom: .04em solid rgba(211, 211, 211, .100)
	}
	
</style>