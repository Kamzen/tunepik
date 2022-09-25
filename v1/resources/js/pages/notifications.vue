<template>

	<div class="wrapper">

		<div v-if="screen">

			<Navigation>
					
					<div class="media-body">
						
						<center>
							
							<span class="app-max-text">
								
								Notifications

							</span>

						</center>

					</div>
					<div class="media-right self-align-center">

						<!-- REMOVE ALL NOTIFICATIONS -->

					</div>

			</Navigation>
			<div class="space-large"></div>
			<div class="space-medium"></div>
			<!-- SHOW NOTIFICATIONS -->

			<NotificationsBundler :notifications="notifications"></NotificationsBundler>

		</div>
		<div class="list-group" v-else>

			<div class="list-group-item item-header">
				
				<!-- DESKTOP NOTIFS HEADER -->

			</div>
			<!-- ADD MORE NOTIFICATIONS -->
			<NotificationsBundler :notifications="notifications"></NotificationsBundler>

		</div>

	</div>
	
</template>

<script>

   import { mapGetters, mapActions } from 'vuex'
   import globs from '../tunepik/attack.js'
   import Navigation from '../components/mobile/root/Navigation'
   import NotificationsBundler from '../components/builders/notifBuilders/NotificationsBundler'

   export default {

   	 name : "Notifications",
   	 data : function(){

   	 	  return {

   	 	  	screen : globs.app.isMobile,

   	 	  }

   	 },
   	 components : {

   	 	Navigation,
   	 	NotificationsBundler

   	 },
   	 methods : {

   	 	...mapActions('notifications', ['getNotifications']),

   	 },
   	 computed : {

   	 	...mapGetters('notifications', ['notifications'])

   	 },

   	 created(){

   	 	this.getNotifications();

   	 }

   };
	

</script>


<style scoped>
	

</style>