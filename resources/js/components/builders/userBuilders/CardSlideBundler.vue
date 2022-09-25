<template>

	<div class="root-level-wrap">

		<!-- Users List Not Empty -->
		<template v-if="users.length > 0">

			<!-- Root Level Wrapper -->
		
		<!-- data-flickity='{freeScroll : false, contain : true, wrapAround : true, autoPlay :4000, prevNextButtons : false, pageDots : false }' -->
			<!-- <div class="cards-wrapper main-carousel" > -->
				<Flickity ref="flickity" :options="options">
				
				<!-- For Loop! -->
				<div class="carousel-cell pt-4" v-for="(user, index) in users">
				
						<UserCardBuilder :user="user"></UserCardBuilder>

				</div>

			</Flickity>

			<!-- </div> -->

		</template>

		<!-- List Empty -->

		<template v-else >
			
			<div class="app-deleted-post grey-matter">
				
				<center>
					<span class="app-post-text">
						No Users To Show
					</span>
				</center>

			</div>

		</template>

	</div>
       
</template>

<script>

  import globs from '../../../tunepik/attack.js'
  import UserCardBuilder from './UserCardBuilder'
  import Flickity from 'vue-flickity'

    export default {

        name       : "CardSlideBundler",
        components : {

        	UserCardBuilder,
        	Flickity

        },
        data    	 : () => {

          return {

            screen 	 : globs.app.isMobile,
            wrapper  : '.main-carousel',
            options : {
			    	 					
  	 					freeScroll : false,
   	  	  	 	contain : true,
             	wrapAround : true,
             	autoPlay : 4000,
             	prevNextButtons : false,
             	pageDots : false

  	 				}

          }

        },
        props 		: ['users'],

       	created   	: function(){

       		/*if(this.users.length > 0){


		    	 		 		setTimeout(() => {

		    	 		 			let wrap = globs.app.get('.cards-wrapper');

		    	 				 
			    	 				let flick = new Flickity(this.wrapper, {
			    	 					
			    	 					freeScroll : false,
			     	  	  	 	contain : true,
			               	wrapAround : true,
			               	autoPlay : 4000,
			               	prevNextButtons : false,
			               	pageDots : false

			    	 				});

		    	 		 		}, 1000 * 60);

		    	 		} 
*/
    	 		 // this.$nextTick(function(){});

        }

    };
</script>

<style scoped>

	.carousel-cell{
		width: 55%;
		height: 250px;
		margin: 2%;
		border : .04em solid rgba(211, 211, 211, .175);
	}

</style>
