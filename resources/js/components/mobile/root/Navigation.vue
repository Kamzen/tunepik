<template>

	<div>
		
		<!-- <div class="breaker" v-if="!screen"></div> -->

		<nav :class="[screen ? 'navbar fixed-top' : 'nav-desktop card-header']">
		
			<div class="media" style="width : 100%;">
				
				<div class="back-btn-wrapper self-align-center mr-3 b-media btn-top">
					
					<a @click="back()">
						<Icon :icon="'back'" :height="24" :width="24" :color="theme.icons.color"></Icon>
					</a>

				</div>

				<slot />

			</div>

			<snack-bar v-if="screen"></snack-bar>

		</nav>

	</div>

</template>

<script>

	import { mapGetters } from 'vuex'
	import globs from '../../../tunepik/attack.js'

	export default {

		name : "Navigation",
		data : () => ({
			screen : globs.app.isMobile
		}),
		methods : {

      back : function(){
        window.history.back();
      }

    },
    computed : {
    	...mapGetters('tunepik', ['theme']),
    	navbar : function(){
    		return screen ? 'navbar fixed-top' : 'nav-desktop card-header'
    	}
    }

	};

</script>

<style scoped>

  .navbar{

  	height: 45px;
  	box-shadow: 0 .5px .5px rgba(211, 211, 211, .2)

  }

  .b-media{
		padding: 5px;
		border-radius: 50%;
		background-color: rgba(211, 211, 211, .175); 
	}

	
	
</style>