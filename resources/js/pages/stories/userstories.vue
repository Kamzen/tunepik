<template>

		<div class="wrapper">
			<story-item></story-item>
		</div>
	
</template>

<script type="text/javascript">
	
	import StoryItem from '../../components/builders/storyBuilders/StoryItem'

	export default {

		name : 		"userstories",
		components : {
			StoryItem
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

			.cover-img{

				width: 100%;
				height: 200px;

			}

		}

</style>