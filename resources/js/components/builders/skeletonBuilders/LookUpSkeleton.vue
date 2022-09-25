<template>
	
	<div class="list-group">
		
		<div class="list-group-item" v-for="(_, i) in [1, 2, 3 , 4]" :key="i">
			
			<div class="media">
				<div class="media-left img-shade skeleton-shimmer skeleton-image"></div>
				<div class="media-body pl-2 align-self-center">
					<div class="skeleton-shimmer skeleton-name"></div>
				</div>
			</div>

		</div>

	</div>

</template>

<script type="text/javascript">

		export default {

			name  : "LookUpSkeleton",

		};

</script>

<style type="text/css" scoped></style>