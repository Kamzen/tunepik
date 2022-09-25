<template>

	<nav class="navbar fixed-top navbar-light bg-white">
		
		<div class="media" style="width : 100%;">
			
			<div class="back-btn-wrapper self-align-center">
				
				<svg-vue icon="back" class="app-icon"></svg-vue>

			</div>

			<slot />

		</div>

	</nav>
	


</template>

<script>
	
	export default {

		name : "Navigation"

	};

</script>

<style scoped>

  .navbar{

  	height: 50px;
  	box-shadow: 0 .5px 1px rgba(211, 211, 211, .4)

  }
	
</style>