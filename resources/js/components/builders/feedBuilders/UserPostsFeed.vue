<template>

	<PostsBundler :posts="posts.userposts" :type="type" :loading="posts.loading" :list="posts.list" :message="posts.message"></PostsBundler>

</template>

<script>

	import { mapGetters, mapActions } from 'vuex'
  import globs from '../../../tunepik/attack.js'
  import PostsBundler from '../postBuilders/PostsBundler'

   export default {

   	name : "UserPostsFeed",
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

   		...mapActions("profile", ['getUserPosts']),

   	},
   	computed : {

   		...mapGetters("profile", ['posts']),
   		Id : function(){

   			this.id = this.user.getBasic().id;

   			return this.id;
   		}

   	},
   	created(){

   		this.getUserPosts({url : `/api/posts/user/${this.Id}/`});

   	}

   };


</script>


<style scoped>


</style>
