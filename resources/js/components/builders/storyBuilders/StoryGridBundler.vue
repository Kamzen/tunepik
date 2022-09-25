<template>

	<div class="wrapper">
		
		<story-grid-skeleton v-if="stories.loading"></story-grid-skeleton>
		<div class="story-grid-wrapper" v-else>
			
			<masonry
			   :cols="{default : 4, 1000 : 3, 700 : 4, 400 : 2}"
			   :gutter="{default : '3px', 700 : '3px', 400 : '3px'}"
					>
	   		<add-story></add-story>
	   		<story-face :user="model"></story-face>
				<story-face :user="model"></story-face>
				<story-face :user="model"></story-face>
				<story-face :user="model"></story-face>
				<story-face :user="model"></story-face>
				<story-face :user="model"></story-face>
				<story-face :user="model"></story-face>
				<story-face :user="model"></story-face>
				<story-face :user="model"></story-face>
				<story-face :user="model"></story-face>
				<story-face :user="model"></story-face>
				<story-face :user="model"></story-face>
				<story-face :user="model"></story-face>
				<story-face :user="model"></story-face>
				<story-face :user="model"></story-face>
	   		<div class="wrap-story-items" v-for="(story, i) in stories" :key="i">
						
					<router-link :to="{ name : 'stories', params : { username : story.user.getBasic().handle, id : story.user.getBasic().id } }">
						<a @click="SET_VIEW_INDEX({index : i})">
							<story-face :user="story.user"></story-face>
						</a>
					</router-link>

				</div>

	   </masonry>

		</div>

	</div>
	
</template>

<script type="text/javascript">

	import { mapGetters, mapActions, mapMutations } from 'vuex'
	import StoryGridSkeleton from '../skeletonBuilders/StoryGridSkeleton'
	
	export default {

		name 		: "StoryGridBundler",
		props 	: ['url'],
		components : {
			StoryGridSkeleton,
		},
		methods : {
			...mapActions("story", ['getStories']),
			...mapMutations("story", ['SET_VIEW_INDEX'])
		},
		computed : {
			...mapGetters("story", ['stories']),
			...mapGetters("auth", ['model'])
		},
		mounted : function(){
			this.$nextTick(() => {
				this.getStories({ url : this.url })
			})
		}

	};

</script>

<style type="text/css" scoped></style>