<template>

	<div class="liked-wrapper">

		<!-- <PostsLayoutTab :headerText="header" :user="profile.model" ></PostsLayoutTab> -->
		
		<div class="space-small"></div>

		<LikedPostsFeed :user="profile.model"></LikedPostsFeed>

	</div>
	
</template>

<script>


	import { mapGetters, mapActions } from 'vuex'
  import PostsLayoutTab from '../../components/builders/profileBuilders/PostsLayoutTab'
  import LikedPostsFeed from '../../components/builders/feedBuilders/LikedPostsFeed'
	
	export default {

		name 				: "Liked",
		scrollToTop : false,
		data 				: function(){

			return {

				header 	: 'Liked'

			};

		},
		components 	: {

			PostsLayoutTab,
			LikedPostsFeed

		},
 		computed  : {

        ...mapGetters("profile", ["profile"])

      },
      methods : {

        ...mapActions("profile", ["setUserProfile", "getUserProfile"])

      }

	};

</script>