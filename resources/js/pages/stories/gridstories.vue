<template>
	
	<div class="wrapper">
		
		<Navigation>
			
			<div class="media-body align-self-center">
				<span class="app-max-text">Stories</span>
			</div>

		</Navigation>
		<div class="space-large"></div>
		<div class="space-large"></div>
		<story-grid-bundler :url="url"></story-grid-bundler>

	</div>

</template>

<script type="text/javascript">
	
	import StoryGridBundler from '../../components/builders/storyBuilders/StoryGridBundler'
	import Navigation from '../../components/mobile/root/Navigation'
	export default {
		name 		: "gridstories",
		data : () => ({
			url : '/api/stories/all'
		}),
		components : {
			StoryGridBundler,
			Navigation
		}
	};

</script>

<style type="text/css" scoped></style>