<template>


		<div class="wrapper">
			
			<Navigation v-if="screen && checks.done">
				
				<div class="media-body align-self-center">

						<span class="app-max-text">
							{{ header }}
						</span>

				</div>

			</Navigation>

			<WorkFiles :round="avatar" :ratio="4/3" v-if="file" class="work-file" ref="workfile"></WorkFiles>

			<UploadCover></UploadCover>

			<div class="navbar fixed-bottom bg-white container" v-if="checks.done && file">
			 	
			 	<v-button class="mobile-share-control-btn send-post-xs yes" :nativeType="'button'" :type="'primary'" @click.native="userUpload(form)">Update</v-button>

				<v-button class="mobile-share-control-btn cancel-post-xs no" @click.native="back()" :type="'danger'">Cancel</v-button>

			</div>


		</div>

	
</template>

<script type="text/javascript">
		
		import { mapGetters, mapActions, mapMutations } from 'vuex'
		import Navigation from '../../../mobile/root/Navigation'
		import globs from '../../../../tunepik/attack.js'
		import WorkFiles from '../../uploadBuilders/WorkFiles'
		import UploadCover from '../../uploadBuilders/UploadCover'

		export default {

			name  : "ChangeAvatar",
			components : {

				Navigation,
				WorkFiles,
				UploadCover

			},
			data : () => ({
				screen      : globs.app.isMobile,
			}),
			props : ['avatar'],
			methods  : {

				...mapActions("upload", ['userUpload']),
				...mapActions("files", ['cancel']),
				...mapMutations("files", ['isSet', 'chosen', 'isFile', 'done']),
				...mapMutations("tunepik", ['SNACK_BAR']),
				back : function(){

					this.cancel();
					history.back();

				}

			},
			computed : {

				...mapGetters("upload", ['upload']),
				...mapGetters("files", ['image', 'checks', 'file']),
				...mapGetters("auth", ['model']),
				uploadedfile  : function(){

				  	return this.image.file || '';

				},
				form  : function(){

					return {
									media : this.uploadedfile,
									text  : '',
									url : this.avatar ? '/api/upload/profile' : '/api/upload/cover'
								}

				},
				header : function(){

					return this.avatar ? 'Change Avatar' : 'Change Cover'

				},
				page : function(){

					return {

						url 		: this.avatar ? 'profile' : 'cover',
						rounded : this.avatar,
						header  : this.avatar ? 'Edit Avatar' : 'Edit Cover'

					}

				}

			},
			watch : {

				uploadedfile : function(val){

					this.form.media = val

				},
				'upload.data' : function(data){
					if(data) {

						if(data.type == 'profile'){
							this.model.getImgs().profile = data.url
						}else{
							this.model.getImgs().cover = data.url
						}

						this.SNACK_BAR({ isOpen : true, message : this.upload.message, theme : 'primary' })

						this.back()

					}
				}

			}

		};

</script>

<style type="text/css" scoped>
	
	@media only screen and (max-width: 700px){

		.wrapper{

			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			width: 100%;
			height: 100%;
			/*z-index: 99999 !important;*/
			overflow-y: auto;

		}

	}

</style>