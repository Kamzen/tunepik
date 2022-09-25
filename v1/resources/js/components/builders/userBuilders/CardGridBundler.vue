<template>

	<div class="root-level-wrap">

		<!-- Users List Not Empty -->
		<template v-if="users.length > 0">

			<!-- Root Level Wrapper -->
			
			<div class="cards-wrapper">
				
				<!-- For Loop! -->
				<div class="spacer m-1 grid-item" v-for="(user, index) in users">
				
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
  import Isotope from 'isotope-layout'

    export default {

        name       : "CardGRidBundler",
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


       			setTimeout(() => {

       				let grid = new Isotope('.cards-wrapper', {

       					itemSelector	: '.grid-item',
  							layoutMode		: 'fitRows'

       				});

       			}, 2000);


        }

    }
</script>

<style scoped>

  .grid-item{

  	width : auto;
  	height : auto;

  }

</style>
