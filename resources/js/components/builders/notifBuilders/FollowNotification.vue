<template>

	<router-link :to="{ name : 'profile', params :{ username : notification.getBasic().handle } }" class="follow-item">

		<a @click="SET_PROFILE(notification)">

		<div class="media">

			<div class="user-img-wrapper align-self-center">
	 			 	
		 	  <Picture :height="35" :width="35" :user="notification"></Picture>

		  </div>
			
			<div class="media-body pl-2 align-self-center">
			 	 			
	 			<span class="app-grey-text-lg">
	 				<span class="app-bolder-text">{{ notification.getBasic().name }}</span>
	 				{{ notification.getNotification().notifType }}
	 			</span>

	 		</div>

	 		<div class="media-right align-self-center">
	 			
	 			<i class="app-fa fa fa-user-plus" v-if="notification.getNotification().notifType == 'Started Following You'"></i>

	 			<i class="app-fa fa user-times" v-else></i>

	 		</div>


		</div>

		<FollowButton :user="notification" :classes="'btn-sm btn-block'"></FollowButton>
		</a>
	</router-link>
	
</template>

<script type="text/javascript">

  import { mapMutations } from 'vuex'
  import FollowButton from  '../userBuilders/FollowButton'
	
	export default {

		name : 'FollowNotification',
		props : ['notification'],
		methods : {
			...mapMutations('profile', ['SET_PROFILE']),
		},
		components : {
			FollowButton
		}

	};

</script>

<style type="text/css" scoped></style>