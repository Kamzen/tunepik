<template>

	<div class="cover">
		
		<ShareBodyBuilder :post="post"></ShareBodyBuilder>

	</div>
	
</template>

<script type="text/javascript">

	import ShareBodyBuilder from '../postBuilders/ShareBodyBuilder'

	export default {

		name : 		"PostSnippet",
		data : () => ({

		}),
		components : {
			ShareBodyBuilder
		},
		props : ['post'],

	};
	
</script>

<style type="text/scss" scoped>
	
</style>