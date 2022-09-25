<template>

	<div class="wrapper">
		
		<div class="row">
					
					<div class="col-lg-8">

					   <transition name="fade" mode="out-in">
			        	<router-view />
			       </transition>

					</div>
					<div class="col-lg-4 mt-1" v-if="!screen">feerg</div>

		</div>

	</div>
	
</template>

<script>

  import {mapGetters, mapActions} from 'vuex'
  import globs from '../../../tunepik/attack.js'
  
  

  export default {

  	name : "UserExtendedView",
  	components :{

  	},
  	data : function(){

  		return {

  			screen : globs.app.isMobile

  		}

  	},
  	props : ['user']

  };
	

</script>

<style scoped>

</style>