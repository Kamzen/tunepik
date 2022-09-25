<template>

	<div class="wrapper">
		
		<template v-for="item in limit">
			<single-post-skeleton></single-post-skeleton>
		</template>

	</div>
	
</template>

<script>

		import globs from '../../../tunepik/attack.js'
		import SinglePostSkeleton from './SinglePostSkeleton'

		export default {

			name 			: "PostSkeleton",
			data : () => ({
				limit : globs.limit,
			}),
			components : {
				SinglePostSkeleton
			},
		};
	
</script>

<style scoped>

</style>