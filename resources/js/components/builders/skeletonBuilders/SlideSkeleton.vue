<template>

		<div class="wrapper">
			
			<Flickity ref="flickity" :options="options">
				
				<div v-for="(item, i) in list">
					
					<div class="skeleton-shimmer block-shade m-2"></div>

				</div>

			</Flickity>

		</div>
	
</template>

<script>

		import globs from '../../../tunepik/attack.js'
		import Flickity from 'vue-flickity'

		export default {

			name 		: "SlideSkeleton",
			components : {

				Flickity

			},
			data 		: function(){

				return {

					list    : globs.limit,
					options : {
			    	 					
  	 					freeScroll : false,
   	  	  	 	contain : true,
             	wrapAround : true,
             	autoPlay : 4000,
             	prevNextButtons : false,
             	pageDots : false

  	 				}

				};

			},

		};
	
</script>

<style scoped>

  .block-shade{

  	width: 200px;
  	height: 250px;

  }
	
</style>