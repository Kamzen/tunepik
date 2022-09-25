<template>

	<div class="wrapper">
		
		<transition name="fade" mode="out-in">
    	<router-view />
    </transition>

	</div>
	
</template>

<script type="text/javascript">

	export default {

		name 		: 	'register',

	};
	
</script>

<style type="text/css" scoped>

	@media only and screen (max-width: 700px){

		.wrapper{

			width: 100%;
			height: 100%;
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			z-index: 99999 !important;

		}

	}

	@media only and screen (min-width: 700px){}
	
</style>