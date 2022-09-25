<template>


	<ListSkeleton :loading="userspostslist.loading" :message="userspostslist.message" :error="userspostslist.error">
		
		<UserListBundler :message="userspostslist.message" :users="userspostslist.users"></UserListBundler>

	</ListSkeleton>


	
</template>

<script>

		import { mapGetters, mapActions } from 'vuex'
		import ListSkeleton from './ListSkeleton'
		import UserListBundler from '../userBuilders/UserListBundler'

		export default {

			name 		: "PostLists",
			components : {

				ListSkeleton,
				UserListBundler

			},
			props  	: ['url'],
			methods : {

				...mapActions("lists", ['getPostLists'])

			},
			computed : {

				...mapGetters("lists", ['userspostslist']),

			},
			created(){

				this.getPostLists({url : this.url});

			}

		};
	
</script>

<style scoped>
	
</style>