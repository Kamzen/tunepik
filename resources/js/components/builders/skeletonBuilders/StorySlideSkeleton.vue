<template>

	<div class="wrapper">
		
		<Flickity ref="flickity" :options="options">
			
			<div class="" v-for="(_, i) in [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]" :key="i">
				
				<div class="story-skeleton-wrap p-2">
					<div class="img-shade skeleton-shimmer skeleton-image"></div>
				</div>

			</div>

		</Flickity>

	</div>
	
</template>

<script type="text/javascript">

import Flickity from 'vue-flickity'

	export default {

		name : 'StorySlideSkeleton',
		data : () => ({

      wrapper  : '.main-carousel',
      options : {
    	 					
				freeScroll : false,
  	  	contain : true,
       	wrapAround : true,
       	autoPlay : 4000,
       	prevNextButtons : false,
       	pageDots : false

			}

    }),
    components : {
    	Flickity
    }


	};
	
</script>

<style type="text/css" scoped>
	.skeleton-image{
		width: 70px;
		height: 70px;
		border-radius: 50%;
	}
</style>