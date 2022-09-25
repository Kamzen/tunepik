<template>

	<div class="root-level-wrap">

		<!-- Users List Not Empty -->
		<template v-if="users.length > 0">

			<!-- Root Level Wrapper -->
			
			<div class="cards-wrapper">
				<masonry
			   :cols="{default : 2, 1000 : 3, 700 : 2, 400 : 2}"
			   :gutter="{default : '0px', 700 : '0px', 400 : '0px'}"
					>

				
					<!-- For Loop! -->
					<div class="spacer m-1 grid-item" v-for="(user, index) in users">
					
							<UserCardBuilder :user="user" ></UserCardBuilder>

					</div>

				</masonry>

			</div>

		</template>

		<!-- List Empty -->

		<template v-else >
			
			<div class="app-deleted-post grey-matter">
				
				<center>
					<span class="app-small-text">
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

        }

    };
</script>

<style scoped>

  .grid-item{

  	width : auto;
  	height : auto;
  	border : rgba(211, 211, 211, .175);

  }

</style>
