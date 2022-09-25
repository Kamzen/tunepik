<template>

	<div class="root-level-wrap">

		<!-- Users List Not Empty -->
		<template v-if="users.length > 0">

			<!-- Root Level Wrapper -->
			
			<div class="cards-wrapper">
				
				<!-- For Loop! -->
				<div class="spacer mr-2 ml-2 mb-2 carousel-cell" v-for="(user, index) in users">
				
						<UserCardBuilder :user="user" ></UserCardBuilder>

				</div>

			</div>

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
  import Flickity from 'flickity'

    export default {

        name       : "CardSlideBundler",
        components : {

        	UserCardBuilder

        },
        data    	 : () => {

          return {

            screen 	 : globs.app.isMobile,

          }

        },
        props 		: ['users'],

       mounted   	: function(){

        	 		 // if(users.length > 0){

        	 		 	setTimeout(() => {

        	 		 		let wrap = globs.app.get('.cards-wrapper');

        	 				/* Create The Slide */
        	 				let flick = new Flickity('.cards-wrapper', {

        	 					/* Configurations */
        	 					freeScroll : false,
		     	  	  	 	contain : true,
		               	wrapAround : true,
		               	autoPlay : 4000,
		               	prevNextButtons : false,
		               	pageDots : false

        	 				});

        	 		 	}, 4000);

        	 		// } // End Of If

        }

    }
</script>

<style scoped>

</style>
