<template>
 <div >
	<div class="app-loader" v-if="posts.loading"></div>

	<div class="wrapper" v-else>

		<div class="app-deleted-post" v-if="!posts.list">

			<center>
				<span class="app-max-text">
					{{ posts.message }}
				</span>
			</center>

		</div>
		<div v-else>


		</div>

	</div>



	</div>

</template>


<script>

	import GridBundler from '../postBuilders/GridBundler'

	export default {

		name : "GridPostsFeed",
		scrollToTop : false,
		components : {

			GridBundler

		}


	};


</script>

<style scoped>

</style>
