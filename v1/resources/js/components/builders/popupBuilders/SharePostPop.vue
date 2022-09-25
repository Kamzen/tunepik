<template>

		<div class="share-wrapper">

			<AudioRecorder></AudioRecorder>
			
			<div class="space-large"></div>
			<div class="space-large"></div>
			<div class="space-large"></div>
			<div class="space-large"></div>

			<div class="navbar fixed-bottom mobile-share-control" v-if="record.done">
		 	
		    <form class="share-post-form-xs" style="width: 100%;">
					<div class="media" style="width: 100%;">
						<div class="media-left media-middle">
							<center>
								<img class="add-post-img media-object img-circle" width="35" height="35" />
							</center>
						</div>
						<div class="media-body input-wrapper-xs ml-1">
							<textarea class="upload-text app-input-field" placeholder=" Add text/@mentions"></textarea>
						</div>
						<div class="media-right media-middle app-create-right self-align-center ml-2">

							<div class="space-small"></div>
							<label>
								
								<svg-vue icon="gallery" class="app-icon"></svg-vue>

							</label>

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
	
</template>

<script>

		import { mapActions, mapGetters } from 'vuex'
		import AudioRecorder from '../uploadBuilders/AudioRecorder'

 		export default {

 			name 			: "SharePostPop",
 			components  : {

 				AudioRecorder

 			},
 			props 			: ['post'],
			methods 		: {

				...mapActions("recorder", ['init', 'toggleRecording', 'startRecording', 'stopRecording']),

			},
			computed 		: {

				...mapGetters("recorder", ['record'])

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