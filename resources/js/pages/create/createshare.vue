<template>

	<PostExtend :comment="'share'"></PostExtend>
	
</template>

<script type="text/javascript">

	import PostExtend from '../../components/builders/bundlers/PostExtend'
	
	export default {

		name :  'CreateComment',
		components : {
			PostExtend
		}

	};

</script>

<style type="text/scss" scoped>
	
</style>