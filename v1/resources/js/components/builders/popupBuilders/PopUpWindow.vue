<template>

	<div class="wrapper" v-show="show">

		<div class="options-pop card bg-white">

			<div class="card-header">

				<div class="media">
					 	
					 	<div class="media-left"></div>
					 	<div class="media-body">
					 		<center>
					 			<span class="app-max-text">
					 				{{ headerText }}
					 			</span>
					 		</center>
					 	</div>
					 	<div class="media-right self-align-center">
					 		
					 		<a v-on:click="close()">
					 			<svg-vue icon="arrowdown" class="app-icon"></svg-vue>
					 		</a>

					 	</div>

				</div>
				
			</div>
			<div class="card-body">
				<slot />
			</div>

	</div>

</div>
	
</template>


<script>

  export default {

  	name    : "PopUpWindow",
  	props   : ['headerText', 'show'],
  	methods : {

  		close : function(){

  			this.show = !this.show;

  		},

  	},

  };
	
</script>

<style scoped>
	
	.wrapper{

		position: fixed;
		top : 0;
		bottom: 0;
		left: 0;
		right: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(211, 211, 211, .4);
		z-index: 9999 !important;

	}

	.card-body{
		padding: 4px;
	}

	@media only screen and(min-width: 700px){

		

	}


	@media only screen and(max-width: 700px){

		.options-pop{

			width: 100%;
			padding: 0;

		}

	}

</style>
