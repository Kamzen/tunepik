<template>

	<div class="name-wrapper" :style="bdColor">
		
		<center>
			<div class="name" :style="{ backgroundColor : bgColor}">
				<span class="app-max-text">tunepik</span>
			</div>
		</center>

	</div>
	
</template>

<script type="text/javascript">

  import { mapGetters } from 'vuex'

	export default {

		name : 'Name',
		computed : {

			...mapGetters('tunepik', ['theme']),
			bgColor : function(){

				return this.theme.type === 'theme-light' ? this.theme.colors.light : (this.theme.type === 'theme-dark' ? this.theme.colors.dark : this.theme.colors.dim)

			},
			oppositeColor : function(){
				return this.theme.type === 'theme-light' ? this.theme.colors.dark : this.theme.colors.light
			},
			bdColor : function(){

				if(this.theme.icons.type === 'default') return { background : `linear-gradient(to right, ${this.oppositeColor}, ${this.theme.colors.blue})` }
					else return { background : `linear-gradient(to right, ${this.oppositeColor}, ${this.theme.icons.color})` }

			}

		}

	};
	
</script>

<style type="text/css" scoped>
	
	@media only screen and (max-width: 700px){
		.name-wrapper {
	  /*max-width: 250px;*/
	 /* padding: 1rem;*/
	  position: relative;
	  top : -3px;
	  /*background: linear-gradient(to right, #5bc0de, purple);*/
	  padding: 3px;
	  border-radius: 6px;
		}
	
		.name {
		  /*background: #222;
		  color: white;*/
		  padding: 4px;/*2rem;*/
		  border-radius: 1.5px;
		}
	}

 @media only screen and (min-width: 700px){

 		.name-wrapper {
	  /*max-width: 250px;*/
	 /* padding: 1rem;*/
	  position: relative;
	  top : -3px;
	  /*background: linear-gradient(to right, #5bc0de, purple);*/
	  padding: 3px;
	  border-radius: 6px;
		}

		.name {
		  /*background: #222;
		  color: white;*/
		  padding: 4px;/*2rem;*/
		  border-radius: 1.5px;
		}

  }

</style>