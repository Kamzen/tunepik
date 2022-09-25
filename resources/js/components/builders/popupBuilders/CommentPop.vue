<template>

		<div class="add-comment-wrapper">
		 	 
		 	 <WorkFiles :round="false" v-if="file"></WorkFiles>
			 <AudioRecorder v-else></AudioRecorder>

			 <UploadCover></UploadCover>

		 	  <div class="space-large"></div>
				<div class="space-large"></div>
				<div class="space-large"></div>
				<div class="space-large"></div>

		 	 <div class="navbar fixed-bottom mobile-share-control" v-if="record.done && checks.done">
		 	
		    <form class="add-post-form-xs" style="width: 100%;" @submit.prevent="userUpload(formDATA)">
					<div class="media" style="width: 100%;">
						<div class="media-left media-middle">
							<center>
								<img class="add-post-img media-object img-circle" width="35" height="35" />
							</center>
						</div>
						<div class="media-body input-wrapper-xs ml-1">
							<textarea class="upload-text app-input-field" v-model="data.text" placeholder="Add text/@mentions"></textarea>
						</div>
						<div class="media-right media-middle app-create-right self-align-center ml-2">

							<div class="space-small"></div>
							
								<clipper-upload v-model="image.src">

									<svg-vue icon="gallery" class="app-icon"></svg-vue>

							  </clipper-upload>

					  </div>
				</div>
					<div class="space-small"></div>
					<div class="button-wrapper" style="width: 100%;">
						
						<button class="btn btn-info mobile-share-control-btn send-post-xs yes">Share</button>
				    <button class="btn btn-danger mobile-share-control-btn cancel-post-xs no">Cancel</button>

					</div>
				</form>

			</div>

	</div>


		</div>

</template>

<script>

		import { mapGetters, mapActions, mapMutations } from 'vuex'
		import AudioRecorder from '../uploadBuilders/AudioRecorder'
		import WorkFiles from '../uploadBuilders/WorkFiles'
		import UploadCover from '../uploadBuilders/UploadCover'

		export default {

			name 				: "CommentPop",
			data   			: function(){

				return {

					form : {
						text  	: this.fieldVal,
						media 	: this.uploadedFile,
					}

				}

			},
			components  : {

				AudioRecorder,
				WorkFiles,
				UploadCover

			},
			props 			: ['post'],
			methods 		: {

				...mapActions("recorder", ['init', 'toggleRecording', 'startRecording', 'stopRecording']),
				...mapMutations("files", ['isSet', 'chosen', 'isFile', 'done']),
				...mapActions("files", ['cancel']),
				...mapActions("upload", ['userUpload']),
				back  : function(){

					this.cancel();

				}

			},
			computed 		: {

				...mapGetters("recorder", ['record']),
				...mapGetters("files", ['image', 'checks', 'file']),
				...mapGetters("upload", ['upload']),
				URL 		 : function(){

					return `/api/upload/comment/${this.post.getPost().id}`;

				},
				fieldVal : function(){

					return `@${this.post.getBasic().handle} `;

				},
				uploadedFile : function(){

						if(this.record.audio.file == null && this.image.file == null){

						 	 return ''

						 }else{

						 	 return this.record.audio.file || this.image.file;

						 }

				},
				formDATA   : function(){

					return {

						text 	: this.form.text,
						media : this.form.media,
						url   : `/api/upload/comment/${this.post.getPost().id}`,

					}

				}

			},
			watch 			 : {

				'image.src' : function(val){

				 	/*this.$store.commit('files/isSet', val != "");
				 	this.$store.commit('files/chosen', val != "")*/

				 	this.isFile(val != "");
				 	this.done(val == "")
					this.isSet(val != "");
					this.chosen(val != "");

				},
				uploadedFile : function(val){

					this.form.media = val;

				}

			}

		};
	
</script>

<style scoped>

	.input-wrapper-xs{
		border-bottom: .05em solid rgba(211, 211, 211, .4);
  }

  .mobile-share-control{
  	border-top: .05em solid rgba(211, 211, 211, .4);
  	width: 100%;
  	background-color: #fff;
  }
	
</style>