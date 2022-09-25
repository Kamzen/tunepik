<template>

	<div class="wrapper">
		
			<Navigation >
				
				<div class="media-body align-self-center">
					<span class="app-max-text">
						Blocked Accounts
					</span>
				</div>
				<div class="media-right p-3"></div>

			</Navigation>
			<div class="visible-xs space-large"></div>
			<div class="visible-xs space-medium"></div>
			<template v-if="blocked.loading">
				<user-list-skeleton></user-list-skeleton>
			</template>
			<template v-else>
				
				<div class="app-deleted-post grey-matter" v-if="blocked.error">
					
					<center>
						<span class="app-small-text">
							{{ blocked.message }}
						</span>
					</center>

				</div>
				<div class="list-group no-border no-pad" v-else>
					
					<div class="list-group-item no-border no-pad" v-for="(user, index) in blocked.users">
					
						<UserRowBuilder :user="user"></UserRowBuilder>

					</div>

				</div>

			</template>


	</div>
	
</template>

<script type="text/javascript">

	import axios from 'axios'
	import globs from '../../../tunepik/attack.js'
	import UserListSkeleton from '../../../components/builders/skeletonBuilders/UserListSkeleton'
	import Navigation from '../../../components/mobile/root/Navigation'
	import UserRowBuilder from '../../../components/builders/userBuilders/UserRowBuilder'

	export default {

		name  : "Blocked",
		scrollToTop : false,
		data  : function(){

			return {

				blocked : {

					loading  : false,
					list     : false,
					error 	 : false,
					message  : '',
					users    : []

				},
				screen : globs.app.isMobile,

			}

		},
		components : {

			UserListSkeleton,
			Navigation,
			UserRowBuilder

		},
		methods : {

			getBlocked : async function(){

				 this.blocked.loading = true;

				 const { data } = await axios.get('/api/user/blocked');

				 this.blocked.error = data.error;
				 this.blocked.message = data.message;

				 this.blocked.loading = false;

				 if(!data.list) return;

				 data.users.forEach((user, index) => {

				 		this.blocked.users.push(new globs.model.user(user.user_info));

				 });


			}


		},
		computed : {


		},
		mounted : function(){

			this.$nextTick(function(){

				this.getBlocked();

			});

		}

	};
	
</script>

<style type="text/css" scoped>

	@media only screen and (max-width: 700px){

		.wrapper{
			z-index: 9999 !important;
			position: fixed;
			top : 0;
			bottom: 0;
			left: 0;
			right: 0;
			width: 100%;
			height: 100%;
			overflow-y: auto;
			background-color: #fff;

		}

		.list-group-item{
			border-bottom: .04em solid rgba(211, 211, 211, .100);
		}

	}

	
</style>