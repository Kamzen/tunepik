<template>

	<div class="face-wrapper">
		
		<hr />

		<div class="card no-border">
		
			<div class="card-header no-border">
				
				<div class="media">
					<div class="media-body align-self-center">
						<span class="app-max-text">Setup Selfie ID</span>
				    <span class="block-text" style="line-height:1">for (@{{ model.getBasic().handle }})</span>
					</div>
					<div class="media-right align-self-center">
						
						<v-button :type="'danger'">Remove Selfie ID &nbsp;<i class="fa fa-trash app-fa"></i></v-button>

					</div>
				</div>

			</div>
			<div class="card-body no-border">

				<div class="p-2">
		    	<span class="app-grey-text">
		    		With Selfie Setup, You Can Login Into Your Account With Your Face Without Being Required To Input Any Email Address or Password.
		    		Making This Type Of Login Extra Secured
		    	</span>
		    </div>
				
				<div class="no-face-id grey-matter pt-3 pb-3">
					
					<center v-if="model.getBasic().hasFace">
						
						<span class="app-small-text">
							You Have Selfie ID Setup, Update Your Selfie ID
						</span>

						<div class="space-medium"></div>

						<router-link :to="{ name : 'camera.faceid' }">
							<v-button :type="'primary'">Update Selfie ID &nbsp;<i class="fa fa-camera app-fa"></i></v-button>
						</router-link>

					</center>
					<center v-else>
						<span class="app-small-text">
							You Haven't Setup Your Selfie ID
						</span>

						<div class="space-medium"></div>

						<router-link :to="{ name : 'camera.faceid' }">
							<v-button :type="'primary'">Setup &nbsp;<i class="fa fa-camera app-fa"></i></v-button>
						</router-link>

					</center>

				</div>

			</div>

		</div>

	</div>
	
</template>

<script type="text/javascript">

	import { mapGetters } from 'vuex'

	export default {

		name 	: 'SetupFacialRecog',
		computed : {

			...mapGetters('auth', ['model'])

		}

	};
	
</script>

<style type="text/css" scoped>
	
</style>