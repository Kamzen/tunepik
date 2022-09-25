<template>

		<div class="wrapper card no-border">
			
			<div class="media card-header">
				
				<div class="media-body align-self-center">
					<span class="app-max-text">
						Stories
					</span>
				</div>
				<div class="media-right align-self-center">
					<Icon :icon="'grid'" :height="24" :width="24"></Icon>
				</div>

			</div>
			<div class="card-body">
				
				<slot></slot>

			</div>

		</div>
	
</template>

<script type="text/javascript">
	
	export default {

		name 			: "StoryHeader",

	};

</script>

<style type="text/css" scoped></style>