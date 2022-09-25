<template>

	 <div class="loading" v-if="notifications.loading">
	 	
	 	<div class="space-large"></div>
	 	<div class="space-large"></div>
	 	<div class="space-large"></div>
	 	<center>
	 		<div class="app-loader"></div>
	 	</center>

	 </div>
	 <div v-else>
	 	
	 	 <template v-if="notifications.list">
	 	 	<!-- Show Notifications -->

	 	 	<div class="list-group" v-for="(notification, index) in notifications.notifs">

	 	 		<div class="list-group-item media">
	 	 			
	 	 			<!-- Image Wrapper For Each Notification Item -->
	 	 			 <div class="user-img-wrapper self-align-start">
	 	 			 	
	 	 			 	  <img class="rounded-circle" height="45" width="45" :src="'' + notification.getImgs().profile" />

	 	 			 </div>

	 	 			 <!-- Media Body!! -->

	 	 			 <!-- Show Like Notification -->
	 	 			 <div class="media-body pl-2" v-if="notification.getNotification().notifType == 'like'">
	 	 			 	
	 	 			 		<span class="app-grey-text-lg" v-if="notification.getNotification().count - 1 <= 0">
	 	 			 			
	 	 			 			<span class="app-bolder-text">{{ notification.getBasic().name }}</span>
	 	 			 			 Has Liked Your Post
	 	 			 		</span>
	 	 			 		<span class="app-grey-text-lg" v-else>
	 	 			 			
	 	 			 			 <span class="app-bolder-text">{{ notification.getBasic().name }}</span> and 
	 	 			 			 <span class="app-bolder-text">{{ notification.getNotification().count - 1 }} Others</span>
	 	 			 			 Liked Your Post
	 	 			 		</span>

	 	 			 </div>

	 	 			 <!-- Show Comment Notification -->
		 	 		<div class="media-body pl-2" v-else-if="notification.getNotification().notifType == 'comment'">
		 	 			
		 	 			  <span class="app-grey-text-lg" v-if="notification.getNotification().count - 1 <= 0">
	 	 			 			
	 	 			 			<span class="app-bolder-text">{{ notification.getBasic().name }}</span>
	 	 			 			 Has Commented Your Post
	 	 			 		</span>
	 	 			 		<span class="app-grey-text-lg" v-else>
	 	 			 			
	 	 			 			 <span class="app-bolder-text">{{ notification.getBasic().name }}</span> and 
	 	 			 			 <span class="app-bolder-text">{{ notification.getNotification().count - 1 }} Others</span>
	 	 			 			 Commented Your Post
	 	 			 		</span>

		 	 		</div>

		 	 		<!-- Show Follow/ UnFollow Notification -->
		 	 		<div class="media-body pl-2" v-else-if="notification.getNotification().notifType == 'Started Following You' || notification.getNotification().notifType == 'Unfollowed You'">
		 	 			
		 	 			<span class="app-grey-text-lg">
		 	 				<span class="app-bolder-text">{{ notification.getBasic().name }}</span>
		 	 				{{ notification.getNotification().notifType }}
		 	 			</span>

		 	 		</div>

		 	 		<!-- Show Mention Notification -->
		 	 		<div class="media-body pl-2" v-else>
		 	 			
		 	 			<span class="app-grey-text-lg">
		 	 				<span class="app-bolder-text">{{ notification.getBasic().name }}</span>
		 	 				Has {{ notification.getNotification().notifType }}
		 	 			</span>

		 	 		</div>
		 	 		<!-- End Of Media Body -->

		 	 		<!-- Media Right Starts Here -->

		 	 		<div class="media-right self-align-center" v-if="notification.getNotification().notifType == 'like'">
		 	 			
		 	 			<i class="fas fa-heart like-icon app-fa fa-2x"></i>

		 	 		</div>

	 	 			 <!-- Show Comment Notification -->
		 	 		<div class="media-right self-align-center" v-else-if="notification.getNotification().notifType == 'comment'">
		 	 			
		 	 			<i class="fas fa-comments-o comment-icon app-fa fa-2x"></i>

		 	 		</div>

		 	 		<!-- Show Follow/ UnFollow Notification -->
		 	 		<div class="media-right self-align-center" v-else-if="notification.getNotification().notifType == 'Started Following You' || notification.getNotification().notifType == 'Unfollowed You'">
		 	 			
		 	 			<FollowButton :user="notification"></FollowButton>

		 	 		</div>

		 	 		<!-- Show Mention Notification -->
		 	 		<div class="media-right self-align-center" v-else>
		 	 			
		 	 			 <i class="fas fa-user-o mention-icon app-fa fa-2x"></i>

		 	 		</div>


	 	 		</div> <!-- End Of Group List Item -->


	 	 	</div>



	 	 </template>
	 	 <template v-else>
	 	    
	 	    <div class="space-large"></div>
	 	    <div class="space-large"></div>

	 	 	  <div class="app-deleted-post grey-matter">
	 	 	  	
	 	 	  	<center>
	 	 	  	
		 	 	  	<span class="app-max-text">
		 	 	  		{{ notifications.message }}
		 	 	  	</span>

		 	 	  </center>

	 	 	  </div>

	 	 </template>

	 </div>
	
</template>

<script>

	import FollowButton from  '../userBuilders/FollowButton'

  export default {

  	name  : "NotificationsBundler",
  	data  : function(){

  		return {};

  	},
  	components : {
  		FollowButton
  	},
  	props : ['notifications']

  };


</script>


<style>

   .comment-icon,
   .mention-icon{

   	 color: rgba(211, 211, 211, 1);

   }

   .like-icon{
   	color: red;
   }

</style>