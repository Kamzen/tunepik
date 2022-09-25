<template>


		<div class="" v-if="loading">
			
			<UserListSkeleton></UserListSkeleton>

		</div>
		<div v-else>
			
			<div v-if="error">

				<div class="space-large"></div>
				<div class="app-deleted-post grey-matter">

					<center>
						<span class="app-post-text">{{ message }}</span>
					</center>

			  </div>

			</div>
			<div class="" v-else>
				
				<slot />

			</div>

		</div>
	
</template>

<script>

		import UserListSkeleton from '../skeletonBuilders/UserListSkeleton'

   export default {

   		name 			: "ListSkeleton",
   		components : {

   			UserListSkeleton

   		},
   		props 		: ['loading', 'message', 'error'],

   };
	
</script>

<style scoped>
	
</style>