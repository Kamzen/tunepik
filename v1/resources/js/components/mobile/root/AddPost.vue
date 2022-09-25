<template>

	<div class="add-post-root">
		
		 <Navigation >
		 	
		 		<div class="media-body">
		 			
		 			<center>
		 				<span class="app-max-text">
		 					Compose Post
		 				</span>
		 			</center>

		 		</div>

		 </Navigation>
		 <div class="space-large"></div>
		 <div class="space-large"></div>
		 <div class="space-large"></div>

		 <AudioRecorder></AudioRecorder>



		 <!-- Bottom Navigation! -->

		 <div class="navbar fixed-bottom mobile-share-control" v-if="record.done">
		 	
		    <form class="add-post-form-xs" style="width: 100%;">
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

		import { mapGetters, mapActions } from 'vuex'
		import Navigation from './Navigation'
		import AudioRecorder from '../../builders/uploadBuilders/AudioRecorder'

		export default {

			name 				: "AddPost",
			data 				: function(){

				return {};

			},
			components 	: {

				Navigation,
				AudioRecorder

			},
			methods 		: {

				...mapActions("recorder", ['init', 'toggleRecording', 'startRecording', 'stopRecording']),

			},
			computed 		: {

				...mapGetters("recorder", ['record'])

			}

		};
	
</script>

<style>

  .add-post-root{

  	z-index: 9999 !important;
  	position: fixed;
  	top: 0;
  	bottom: 0;
  	right: 0;
  	left: 0;
  	height: 100%;
  	width: 100%;
  	background-color: white;

  }

  .input-wrapper-xs{
  	border-bottom: .05em solid rgba(211, 211, 211, .6);
  }

  .mobile-share-control{
  	border-top: .05em solid rgba(211, 211, 211, .4);
  	width: 100%;
  	background-color: #fff;
  }	
</style>