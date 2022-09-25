<template>

	<div class="wrapper">
		
		<div class="wrap-story-items" v-for="(story, i) in stories" :key="i">
						
			<router-link :to="{ name : 'stories', params : { username : story.user.getBasic().handle, id : story.user.getBasic().id } }">
				<a @click="SET_VIEW_INDEX({index : i})">
					<story-face :user="story.user"></story-face>
				</a>
			</router-link>

		</div>

	</div>
	
</template>

<script type="text/javascript">

	import StoryFace from './StoryFace'
	import { mapMutations } from 'vuex'

	export default {
		name 		: "StoryBundler",
		props 	: ['stories'],
		components : {
			StoryFace
		},
		methods : {
			...mapMutations("story", ['SET_VIEW_INDEX'])
		}
	};

</script>

<style type="text/css" scoped></style>