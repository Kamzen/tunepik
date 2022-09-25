<template>

	<div class="cover-wrapper" v-show="show">

		<div class="options-wrapper">
			
			<div class="main">
				<slot></slot>
			</div>
			<div class="divider-space">
				<div class="space-medium"></div>
			</div>

			<div class="closer">
				
				<button @click="togglePopUp()" class="btn btn-block btn-danger">
					cancel
				</button>

			</div>

		</div>

	</div>
	
</template>

<script type="text/javascript">
	
	import { mapGetters, mapActions } from 'vuex' 
	export default {

		name 		: "PostPopUp",
		props  	: ['show'],
		methods  : {
			...mapActions('tunepik', ['togglePopUp']),
		},
		computed : {
			...mapGetters('tunepik', ['overlay']),
		}

	};
	
</script>

<style type="text/css" scoped>

		@media only screen and (max-width: 700px){

			.cover-wrapper{

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

			 @keyframes pop-trans-xs{

		    0% {
		      bottom: 0px;
		      opacity: 1;
		    }

		    /*25%{
		      opacity: 1;
		      bottom: 15px;
		    }

		    50% {
		      opacity: 1;
		      bottom: 30px;
		    }*/

		    100%{
		      opacity: 1;
		      bottom: 45px;
		    }

		  }

		  .main{
		  	border-radius: 12px;
		  	padding: 5px;
		  }
		  .options-wrapper{
		    background-color: transparent;
		    border-top: 0.05em solid rgba(211, 211, 211, .100);
		    position: fixed;
		    bottom: 45px;
		    left: 0;
		    right: 0;
		    width: 90%;
		    border-radius: 8px;
		    margin: auto;
		    animation: pop-trans-xs 0.3s;
		    -webkit-animation : pop-trans-xs 0.3s;
		  }

		}

</style>