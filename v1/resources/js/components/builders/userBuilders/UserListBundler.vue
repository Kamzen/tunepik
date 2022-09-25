<template>

	<div class="root-level-wrap">

		<!-- Users List Not Empty -->
		<template v-if="users.length > 0">

			<!-- Root Level Wrapper -->
			
			<div class="list-group">
				
				<!-- For Loop! -->
				<template v-for="(user, index) in users">
				
						<UserRowBuilder :user="user" ></UserRowBuilder>

				</template>

			</div>

		</template>

		<!-- List Empty -->

		<template v-else >
			
			<div class="app-deleted-post grey-matter">
				
				<center>
					<span class="app-post-text">
						{{ message }}
					</span>
				</center>

			</div>

		</template>

	</div>
       
</template>

<script>

  import globs from '../../../tunepik/attack.js'
  import UserRowBuilder from './UserRowBuilder'

    export default {

        name       : "UserListBundler",
        components : {

        	UserRowBuilder

        },
        data    	 : () => {

          return {

            screen 	 : globs.app.isMobile,

          }

        },
        props 		: ['users', 'message'],

    }
</script>

<style scoped>

</style>
