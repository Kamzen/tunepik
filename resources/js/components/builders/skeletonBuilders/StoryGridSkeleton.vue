<template>

	<div class="wrapper">
		
		<masonry
			   :cols="{default : 4, 1000 : 3, 700 : 4, 400 : 2}"
			   :gutter="{default : '3px', 700 : '3px', 400 : '3px'}"
					>
	   		
	   		<div class="img-shade skeleton-shimmer skeleton-image" v-for="(_, i) in [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 19, 20]"></div>

	   </masonry>

	</div>
	
</template>

<script type="text/javascript">
	
	export default {
		name 	: "StoryGridSkeleton",
	};

</script>

<style type="text/css" scoped>
	
	.skeleton-image{
		width: 70px;
		height: 70px;
		border-radius: 50%;
	}

</style>