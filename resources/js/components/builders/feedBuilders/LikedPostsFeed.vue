<template>

	<PostsBundler :posts="liked.likedposts" :type="type" :loading="liked.loading" :list="liked.list" :message="liked.message"></PostsBundler>

</template>

<script>

	import { mapGetters, mapActions } from 'vuex'
  import globs from '../../../tunepik/attack.js'
  import PostsBundler from '../postBuilders/PostsBundler'

   export default {

   	name : "LikedPostsFeed",
      scrollToTop : false,
   	components : {

   		PostsBundler

   	},
   	data : function(){

   		return {

   			screen : globs.app.isMobile,
   			id    : null,
   			type  : 'list'

   		}

   	},
   	props : ['user'],
   	methods : {

   		...mapActions("profile", ['getLikedPosts']),

   	},
   	computed : {

   		...mapGetters("profile", ['liked']),
   		Id : function(){

   			this.id = this.user.getBasic().id;

   			return this.id;
   		}

   	},
   	created(){

   		this.getLikedPosts({url : `/api/posts/liked/${this.Id}/`});

   	}

   };


</script>


<style scoped>


</style>
