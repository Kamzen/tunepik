<template>

	<nav class="navbar fixed-top home-nav">
	  		
	  		<div class="media" style="width : 100%">

	  			<div class="media-body align-self-center">
	  			
	  				
	  				<div class="media">
	  					<Name></Name>
	  					<div class="media-body align-self-center"></div>
	  					<div class="media-right align-self-center pr-3">
	  						
	  						<span  style="display:inline-block;position:relative;bottom:0px;">
		  						<clipper-upload v-model="image.src">
		  							<i class="fa fa-camera app-fa"></i>
		  						</clipper-upload>
			  				</span>

	  					</div>

	  				</div>

	  				
	  			</div>

	  			<div class="media-right align-self-center">

	  				<div class="img-loading skeleton-shimmer" v-if="loading"></div>
            <div class="" v-else>
              
              <div class="" v-if="check">
                
                  <router-link :to="{ name : 'profile', params : { username : model.getBasic().handle } }" class="nav-user-link">
                  	<a @click="SET_PROFILE(model)">
                   		<Picture :width="30" :height="30" :user="model"></Picture>
                    </a>
                  </router-link>
              </div>

            </div>

	  				<!-- <center>
	  					<span class="mr-2" style="display:inline-block;position:relative;top:-4.5px;">
		  					<router-link :to="{ name : 'search' }">
			  					<Icon :icon="'search'" :width="28" :height="28"></Icon>
			  				</router-link>
		  				</span>
	  					
		  				
	  				</center> -->
	  			</div>

	  		</div>

	  	</nav>
	
</template>

<script type="text/javascript">

	import { mapGetters, mapMutations } from 'vuex'
	export default {

		name  : "HeadNavbar",
		methods  : {

			...mapMutations("files", ['isSet', 'chosen', 'isFile', 'done']),
			...mapMutations('profile', ['SET_PROFILE']),

		},
		computed : {

			...mapGetters("auth", ['user', 'check', 'loading', 'model']),
			...mapGetters("files", ['image']),


		},
		watch  : {

			'image.src' : function(val){

				this.isFile(val != "");
			 	this.done(val == "")
				this.isSet(val != "");
				this.chosen(val != "");

				this.$router.push({ name : 'createPost' });

			}
		}

	};
	
</script>

<style type="text/css" scoped>

 	.app-icon{
    height : 22px;
    width : 22px;
  }

  .app-nav-table{

    position: relative;
    top: -5px;

  }

/*  .app-nav{
    height: auto;
  }
*/
  .img-loading{

    width: 30px;
    height: 30px;
    border-radius: 15px;

  }
	
</style>