<template>

	<div class="root-wrapper">

		<div class="space-large"></div>
		<div class="space-large visible-lg"></div>
		<div class="space-medium visible-xs"></div>
		<div class="space-small visible-xs"></div>

		<div v-if="screen">

			<Navigation>
				
				<div class="media-body">

						<center>
							
							<span class="app-max-text">
								Discover
							</span>

						</center>

				</div>

				<div class="media-right"></div>

			</Navigation>

			<ExploreBundler></ExploreBundler>

		</div>
		<div class="card" v-else>
			<div class="card-header">
				
				<span class="app-max-text">
					Discover
				</span>

			</div>
			<div class="card-body">
				
				<ExploreBundler></ExploreBundler>

			</div>
		</div>

	</div>
	
</template>

<script>

		import globs from '../tunepik/attack.js'
		import Navigation from '../components/mobile/root/Navigation'
		import ExploreBundler from '../components/builders/bundlers/ExploreBundler'
	
		export default {

			name 				: "Explore",
			scrollToTop : false,
			components 	: {

				Navigation,
				ExploreBundler

			},
			data 				: function(){

				return {

					screen : globs.app.isMobile

				};

			},


		};

</script>

<style scoped>
	
</style>