<template>

	<div class="app-loader" v-if="posts.loading"></div>

	<div class="wrapper" v-else>
		
		<div class="app-deleted-post" v-if="!posts.list">
			
			<center>
				<span class="app-max-text">
					{{ posts.message }}
				</span>
			</center>

		</div>

	</div>



	</div>
	
</template>


<script>
	
	export default {

		name : "GridPostsFeed",
		components : {

		},
		props : ['posts']


	};


</script>

<style scoped>
	
</style>