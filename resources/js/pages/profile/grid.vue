<template>

	<div class="">

		<PostsLayoutTab :headerText="header" :user="profile.model" ></PostsLayoutTab>

	</div>
	
</template>

<script>


	import { mapGetters, mapActions } from 'vuex'
  import PostsLayoutTab from '../../components/builders/profileBuilders/PostsLayoutTab'
	
	export default {

		name 				: "Grid",
		scrollToTop : false,
		data 				: function(){

			return {

				header 	: 'Grid'

			};

		},
		components 	: {

			PostsLayoutTab

		},
 		computed  : {

        ...mapGetters("profile", ["profile"])

      },
      methods : {

        ...mapActions("profile", ["setUserProfile", "getUserProfile"])

      }

	};

</script>