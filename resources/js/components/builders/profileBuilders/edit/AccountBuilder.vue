<template>
	
		<div class="edit-account-wrapper">
		
			<form id="update-form" @submit.prevent="updateUserInfo(form, profile.model)">

		 <ChangeAvatar :avatar="avatar" v-if="file"></ChangeAvatar>

			<!-- <div class="change-cover">
				
			</div> -->

			<div class="wrapper-info" v-if="screen && !file">
				
				<div class="card no-border">

					<Navigation >
						
						<div class="media-body align-self-center">
							
								<span class="app-max-text">Account</span>

						</div>
						<div class="media-right mr-2 align-self-center">
							
							<v-button :nativeType="'submit'" class="btn-top" :type="'primary'" :loading="update.loading"> 
								Update
							</v-button>

						</div>

					</Navigation>

					<div class="visible-xs space-large"></div>
					<div class="visible-xs space-large"></div>
					
					<!-- <div class="cover-photo" v-if="!file">

				 		<div class="media media-button">

				 			<div class="pl-3 media-left align-self-center">
				 				
				 				<v-button :nativeType="'button'" :type="'primary'" @click.native="avatar = false">
				  		
						  		<clipper-upload v-model="image.src">Change Banner</clipper-upload>

						  	</v-button>

				 			</div>
				 			
				 			<div class="media-body"></div>

				 		</div>
				  	
				  	<img class="cover-img" :src="model.getImgs().cover"/>

				 </div> -->
					<div class="card-body p-3 no-border" v-if="!file">

						 <div class="space-medium"></div>
							
							<div class="media mb-4">
								
								<div class="media-left align-self-start">

								  <center>
								  	<Picture :user="model" :height="75" :width="75"></Picture>
									  <div class="space-small"></div>
											<v-button :nativeType="'button'" :type="'primary'" @click.native="avatar = true">
												<clipper-upload v-model="image.src">Change Avatar</clipper-upload>
											</v-button>
									</center>

								</div>
								<div class="media-body ml-2 align-self-start">
								     
								    <span class="app-small-text">{{ model.getBasic().name }}</span>
										<span class="app-max-text user-handle block-text">@{{ model.getBasic().handle }}</span>
										<div class="space-medium"></div>
										<span class="app-post-text" v-if="model.getInfo().bio">
											{{ model.getInfo().bio }}
										</span>

								</div>

							</div>				
							<div class="form-group" v-for="(item, key) in list">

								  <div class="info-wrapper" v-if="item.index == 1">
								  	
								  	<span class="app-max-text block-text">Public Information</span>
										<span class="app-grey-text-lg">
											Provide Your Public Infomation For People To Better Identify You And Discover Your Account Through Searching
										</span>
										<div class="space-small"></div>
										
								  </div>
									<div class="info-wrapper" v-if="item.index == 4">
										
										<span class="app-max-text block-text">Personal Information</span>
										<span class="app-grey-text-lg">
											Provide Your Personal Infomation. This Will Not Be Part Of Your Public Profile
										</span>
										<div class="space-small"></div>

									</div>
								
									<label :for="item.index" class="app-bolder-text">{{ item.header }}</label>

									<textarea class="form-control" :id="item.index" :name="item.name" :value="item.value" :placeholder="item.placeholder" v-if="item.index == 3">
										
									</textarea>

									<input type="text" :name="item.name" :id="item.index" class="form-control" :placeholder="item.placeholder" :value="item.value" v-else>

							</div>

							<div class="space-small"></div>

							<div class="pl-3 pr-3">
								
							</div>

					<div class="visible-xs space-large"></div>
					<div class="visible-xs space-large"></div> 

					</div>

				</div>

			</div>

			</form>

		</div>

</template>

<script>
		
		import { mapGetters, mapActions, mapMutations } from 'vuex'
		import globs from '../../../../tunepik/attack.js'
		import Navigation from '../../../mobile/root/Navigation'
		import ChangeAvatar from './ChangeAvatar'

		export default {

				name 			: "AccountBuilder",
				data 			: () => ({
					screen  		: globs.app.isMobile,
					avatar      : '',
				}),
				components : {
					Navigation,
					ChangeAvatar
				},
				methods 	: {
					...mapActions("auth", ['updateUserInfo']),
					...mapMutations("files", ['isSet', 'chosen', 'isFile', 'done']),
					...mapMutations('tunepik', ['SNACK_BAR'])
				},
				computed 	: {
					...mapGetters("auth", ['user', 'update']),
					...mapGetters("profile", ['profile']),
					...mapGetters("files", ['image', 'checks', 'file']),
					form  : function(){
						return globs.app.get('#update-form');
					},
					model : function(){
						return new globs.model.user(this.user.model);
					},
					list 	: function(){
						return [

							{
								index   : 1,
								header  : 'Username',
								name 		: 'ch-name',
								value   : this.model.getBasic().name,
								placeholder : 'Edit Username'
							},
							{
								index   : 2,
								header  : 'Location',
								name    : 'ch-residence',
								value   : this.model.getInfo().location,
								placeholder : 'Edit Location'
							},
							{
								index   : 3,
								header  : 'Bio',
								name 		: 'ch-bio',
								value   : this.model.getInfo().bio,
								placeholder : 'Edit Bio'
							},
							{
								index   : 4,
								header  : 'Email',
								name    : 'ch-email',
								value   : this.model.getBasic().email,
								placeholder : 'Edit Email'
							}

						];

					}

				},
				watch 	: {

					'image.src' : function(val){

					 	this.isFile(val != "");
					 	this.done(val == "")
						this.isSet(val != "");
						this.chosen(val != "");

					},
					model : function(user){
						if(user) this.SNACK_BAR({ isOpen : true, message : this.update.message, theme : 'primary' })
					},
				  'update.error' : function(error){
				  	if(error) this.SNACK_BAR({ isOpen : true, message : this.update.message, theme : 'primary' })
				  }

				}

		};
	
</script>

<style scoped>


		@media only screen and (max-width: 700px){

			.edit-account-wrapper{
				z-index: 9999 !important;
				position: fixed;
				top : 0;
				bottom: 0;
				left: 0;
				right: 0;
				width: 100%;
				height: 100%;
				overflow-y: auto;
				/*background-color: #fff;*/

			}

			.cover-img{

				width: 100%;
				height: 200px;

			}

		}

		.media-button{
			position: relative;
			top: 20px;
			right: 5px;
			height: 0px;
		}
	
</style>