<template>

	<div class="overlay-wrapper" v-show="overlay.confirm.isOpen">

		<div class="options-pop card bg-white">

			<div class="card-header">

				<div class="media">
					 	
					 	<div class="media-left"></div>
					 	<div class="media-body align-self-center">
					 		<center>
					 			<span class="app-max-text">
					 				{{ headerText }}
					 			</span>
					 		</center>
					 	</div>
					 	<div class="media-right align-self-center">
					 		
					 		<a v-on:click="toggleConfirm()">
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

	import { mapGetters, mapActions } from 'vuex'

  export default {

  	name    : "PopUpWindow",
  	props   : ['headerText', 'show'],
  	methods  : {
			...mapActions('tunepik', ['toggleConfirm']),
		},
		computed : {
			...mapGetters('tunepik', ['overlay']),
		}

  };
	
</script>

<style scoped>
	
	.overlay-wrapper{

		position: fixed;
		top : 0;
		bottom: 0;
		left: 0;
		right: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, .175);
		z-index: 9999 !important;

	}

	.card-body{
		padding: 4px;
	}

	.card-header {

		background-color: #fff;

	}

	@media only screen and(min-width: 700px){

		

	}


	@media only screen and(max-width: 700px){


		/*@keyframes pop-trans-xs{

    0% {
      transform: scaleY(0.5); 
    }

    25%{
      opacity: 0.25
    }

    50% {
      opacity: 0.50;
    }

    100%{
      opacity: 1;
      transform: scaleY(1);
    }

  }
  .options-pop{
    background-color: transparent;
    border-top: 0.05em solid rgba(211, 211, 211, .100);
    position: fixed;
    bottom: 0;
    width: 100%;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    animation: pop-trans-xs 0.3s;
    -webkit-animation : pop-trans-xs 0.3s;
  }*/

	}

</style>
