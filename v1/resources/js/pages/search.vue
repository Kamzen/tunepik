<template>

	<div class="wrapper">

		<div class="navbar fixed-top bg-white">
			
			<div class="media">
				
				<div class="media-left self-align-center">
					
					<div class="space-small"></div>
					<a class="back-btn">
						
						<svg-vue icon="back" class="app-icon"></svg-vue>

					</a>

				</div>
				<div class="media-body ml-4">
					
					<div class="search-wrapper">

						<table class="">
							<tr>
								<td class="pl-2">
									<input type="search" name="search" class="xs-search app-search" placeholder="search tunepik..." />
								</td>
								<td class="pr-1">
									<center>
										<span class="search icon-wrapper">
						
										  <svg-vue icon="search" class="search-icon app-icon" style="width:22px;height:22px"></svg-vue>

									  </span>
									</center>
								</td>
							</tr>
						</table>
						

					</div>

				</div>
<!-- 				<div class="media-right">

				</div> -->

			</div>

		</div>

		<div class="space-large"></div>
		<div class="space-medium"></div>

		<div class="search-extend">
			
			<MobileSuggestions></MobileSuggestions>

		</div> 

		<div class="space-large"></div>
		<div class="space-medium"></div>
		<div class="space-large"></div>
		<div class="space-medium"></div>

	</div>
	
</template>

<script>

	import MobileSuggestions from '../components/mobile/root/MobileSuggestions'

  export default {

  	name : "Search",
  	components : {
  		MobileSuggestions

  	},

  };
	
</script>

<style scoped>

   .search-wrapper{

   	border : .05em solid rgba(211, 211, 211, .4);
   	border-radius: 15px;
   	padding: 2px;

   }
   .navbar{
   	height: 50px;
   	box-shadow: 0 .5px 1px rgba(211, 211, 211, .4);
   }

   table{
   	width : 100%;
   }
	
</style>