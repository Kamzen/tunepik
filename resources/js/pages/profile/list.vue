<template>

		<div class="wrapper">
			
				<!-- <PostsLayoutTab :headerText="header" :user="profile.model"></PostsLayoutTab> -->
<!--         <div class="space-small"></div> -->
				<UserPostsFeed :user="profile.model"></UserPostsFeed>


		</div>
	
</template>

<script>

		 import { mapGetters, mapActions } from 'vuex'
		 import UserPostsFeed from '../../components/builders/feedBuilders/UserPostsFeed'
		 import PostsLayoutTab from '../../components/builders/profileBuilders/PostsLayoutTab'

   export default {

   		name 			  : "List",
      scrollToTop : false,
   		data 				: function(){
   			return {

   				header 		: 'Activity'

   			};
   		},
   		components 	: {

   			UserPostsFeed,
   			PostsLayoutTab

   		},
   		computed : {

          ...mapGetters("profile", ["profile"])

        },
        methods : {

          ...mapActions("profile", ["setUserProfile", "getUserProfile"])

        }

   };

</script>

<style scoped>
	
</style>