<template>

	<!-- Root Level Wrapper -->
	<div class="list-group-item">
		
		<div class="media">
			
			<!-- User Image! -->

			<img class="rounded-circle" width="50" height="50" :src="'' + user.getImgs().profile" />

			<div class="media-body ml-3">
				
				<span class="name-wrapper">
					
					<router-link :to="{ name : 'profile', params : { username : user.getBasic().handle } }">
						
						<span class="app-bolder-text">
							{{ user.getBasic().name }}
						</span>

					</router-link>

				</span>
				<div class="text-breaker"></div>
				<span class="app-grey-text" v-if="user.getInfo().bio == null">
					<i class="app-fa fas fa-calendar-alt mr-1"></i>
					Joined On {{ user.getBasic().date }}
				</span>
				<span class="app-post-text" v-else>

					{{ user.getInfo().bio }}

				</span>

			</div>

			<!-- User Follow Btn Wrapper -->
			<div class="user-follow-btn">

				<FollowButton :user="user" :classes="'btn-md btn-block'"></FollowButton>

			</div>

		</div> <!-- End Of Header Media -->

	</div> <!-- End Of Root Level Wrapper -->

       
</template>

<script>

  import globs from '../../../tunepik/attack.js'
  import FollowButton from './FollowButton'

    export default {

        name    : "UserRowBuilder",
        components :{

        	FollowButton

        },
        data    : () => {

          return {

            screen : globs.app.isMobile

          }

        },
        props : ['user']

    };
</script>

<style scoped>

  .list-group-item{
  	padding: 15px;
  	border : .04em solid rgba(211, 211, 211, .4);
  	border-left: 0;
  	border-right : 0;
  }
  .text-breaker{

  	height: 0;

  }

  .app-fa{
  	color : rgba(211, 211, 211, 1);
  }

</style>
