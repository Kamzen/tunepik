<template>

			<div class="wrapper">

					<Navigation>
						<div class="media-body align-self-center">
							<span class="app-max-text">
								Security
							</span>
						</div>
						<div class="media-right p-2">
						</div>
					</Navigation>
					<div class="visible-xs space-large"></div>
					<div class="visible-xs space-large"></div>
					<div class="body-wrapper card-body">

						<div class="info-wrapper">

					  	<span class="app-max-text block-text">Change Your Password</span>
							<span class="app-grey-text-lg">
							 For A Strong Password You Would Want To Use A Combination Of Lower & Uppercase Letters, Numbers and Special Characters
							</span>
							<div class="space-small"></div>

					  </div>

					  <form class="password-form" @submit.prevent="updatePassword()">

					  	<div class="form-group">
					  		<span class="app-post-text text-success" style="" v-if="!password.error">{{ password.message }}</span>
					  		<label class="app-bolder-text">Change Password</label>
					    	<input type="password" name="ch_password" v-model="form.newPassword" class="form-control" placeholder="New Password">
					  	</div>

					    <div class="form-group">

					    	<label class="app-bolder-text">Confirm Password</label>

					    	<input type="password" name="confirm_password" v-model="form.confirmPassword" class="form-control" placeholder="Confirm Password">

					    </div>

					    <hr />

					    <div class="info-wrapper">

						  	<!-- <span class="app-max-text block-text">Public Information</span> -->
								<span class="app-grey-text-lg">
									Enter Your Your Current Password To Update Your New Password
								</span>
								<div class="space-small"></div>

						  </div>

						  <div class="form-group">

					    	<label  class="app-bolder-text">Current Password</label>
					    	<input type="password" name="password" v-model="form.password" class="form-control" placeholder="Current Password">

					    </div>

					    <span class="app-post-text text-danger" v-if="password.error">{{ password.message }}</span>

					    <div class="space-small"></div>
					    <div class="space-small"></div>

					    <div class="pl-4 pr-4">

					    	<center>
					    		<v-button :type="'primary'" :large="true" :block="true">
					    			Update
					    		</v-button>
					    	</center>

					    </div>

					  </form>

					</div>

					 <setup-facial-recog></setup-facial-recog>

					<div class="space-large"></div>
					<div class="space-large"></div>

			</div>

</template>

<script type="text/javascript">

	import { mapActions, mapGetters } from 'vuex'
	import Navigation from '../../../components/mobile/root/Navigation'
	import SetupFacialRecog from './facialrecognition'
	import globs from '../../../tunepik/attack.js'
	import axios from 'axios'

	export default {

		name 		: "Password",
		scrollToTop : false,
		data 		: function(){

			return {

				screen  : globs.app.isMobile,
				message : '',
				form    : {

					newPassword : '',
					confirmPassword : '',
					password : ''

				},
				password : {

					loading : false,
					message : '',
					error   : '',

				}

			}

		},
		components : {

			Navigation,
      SetupFacialRecog

		},
		methods  : {

			ontype : function(){



			},

			updatePassword : async function(){

				this.password.loading = true;

				const form = new FormData(globs.app.get(".password-form"));

				const { data } = await axios.post('/api/user/update/password', form);

				this.password.error = data.error;
				this.password.message = data.message;
				this.password.loading = false;

			}

		},
		computed : {



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

			}

		}



</style>
