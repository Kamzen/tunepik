<template>

	<div class="wrapper p-2">
		
		<center>
			<Picture :user="user" :width="pictureSize" :height="pictureSize"></Picture>
			<!-- <user-name :user="user"></user-name> -->
			<span class="app-grey-text">
				@{{ user.getBasic().handle }}
			</span>
		</center>

	</div>
	
</template>

<script type="text/javascript">
	
	import globs from '../../../tunepik/attack.js'
	export default {

		name 	: "StoryFace",
		data : () => ({
			screen : globs.app.isMobile
		}),
		props : ['user'],
		computed : {
			pictureSize(){
				return this.screen ? 70 : 70
			}
		}
	};

</script>

<style type="text/css" scoped></style>