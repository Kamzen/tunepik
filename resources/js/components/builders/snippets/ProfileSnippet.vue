<template>

	<div class="overlay-wrapper">
		
		<div class="popover-wrapper">
			
			<div class="card">
				
				<div class="card-header">

					<div class="media">
						
						<div class="media-left align-self-center">
							
							<Picture :height="35" :width="35" :user="user"></Picture>

						</div>
						<div class="media-body align-self-center">
							
							<router-link :to="{ name : 'profile', params : { username : user.getBasic().handle } }" class="name-link">

	              <span class="profile-user-name app-max-text">
	                {{ trim(user.getBasic().name, 12) }}
	              </span>
	              <span class="profile-user-handle app-post-text" style="display: block;line-height: 1;">
	                @{{ user.getBasic().handle }}
	              </span>

	            </router-link>

						</div>
						<div class="media-right align-self-center">

							<FollowButton :user="user" :classes="''"></FollowButton>

							<div class="b-media ml-2" style="display:inline-block">
								<i class="fa fa-times app-fa"></i>
							</div>
							
						</div>

					</div>
					
				</div>
				<div class="card-body">
					
					<center>
						
						<i class="app-fa fas fa-calendar-alt"></i>
            <span class="app-grey-text"> Joined On {{ user.getBasic().date }} </span>
            <br />
            <span v-if="user.getInfo().location != null">
              <span class="app-fa fas fa-map-pin"></span>
              <span class="app-grey-text"> {{ user.getInfo().location }}</span>
            </span>


            <div class="user-bio mt-2" style="width: 90%;">
            
            <span class="app-post-text">
              
              {{ user.getInfo().bio }}

            </span>

          </div>

					</center>

					<UserStatsBuilder :user="user"></UserStatsBuilder>


				</div>

			</div>

		</div>

	</div>
	
</template>

<script type="text/javascript">

		import UserStatsBuilder from '../profileBuilders/UserStatsBuilder'
		import FollowButton from '../userBuilders/FollowButton'
		import globs from '../../../tunepik/attack.js'
	
		export default {

			name 		: "ProfileSnippet",
			data : () => ({

				trim  : globs.trim

			}),
			components : {

				UserStatsBuilder,
				FollowButton

			},
			props   : ['user', 'show'],

		};

</script>

<style type="text/css" scoped></style>