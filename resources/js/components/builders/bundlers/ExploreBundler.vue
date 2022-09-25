<template>

	<div class="wrapper">
		
		<GridBundler :posts="explore.posts" :loading="explore.loading" :message="explore.message" :error="explore.error" ></GridBundler>

	</div>
	
</template>

<script>

  import { mapGetters, mapActions } from 'vuex'
  import GridBundler from '../postBuilders/GridBundler'
	
	export default {

		 name 			: "ExploreBundler",
		 components : {

		 	GridBundler

		 },
		 data 			: function(){

		 		return {

		 		};

		 },
		 methods    : {

		 	...mapActions("posts", ["getExplorePosts"]),

		 },
		 computed 	: {

		 	...mapGetters("posts", ['explore']),

		 },
		 created    : function (){

		 	// if(!this.explore.list){

		 		this.getExplorePosts('/api/posts/discover');

		 	// }

		 },
		 watch 			: {

		 },

	};

</script>

<style scoped>
	
</style>