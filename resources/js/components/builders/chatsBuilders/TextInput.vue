<template>

	<div class="navbar fixed-bottom" v-if="!message.loading"> <!-- screen && -->

		<look-up class="look-up-wrap"></look-up>

		<div class="media-wrapper" :style="{width : screen ? '100%' : ''}" v-if="!user.model.getActivity().blocked">
			
			<form :style="{width : screen ? '100%' : ''}" @submit.prevent="sendMessage(formDATA)">
				
				<div class="media" :style="{width : screen ? '100%' : ''}">

					<div class="media-left align-self-center" v-if="record.isRecording || record.audio.file">
						
						<a class="icon-wrapper p-1" @click="cancelRecording()">
							
							<i class="fa fa-times app-fa"></i>

						</a>

					</div>
					

					<div class="media-body align-self-center" style="width:100%;" v-if="record.isRecording || record.audio.file">
						
						<center>
							
							<AudioBodyBuilder :url="record.audio.url" :id="1" v-if="record.audio.file && record.audio.url"></AudioBodyBuilder>
							<div class="skeleton-shimmer record-timer" v-else>
								<samp class="app-max-text">{{ record.time }}</samp>
							</div>

						</center>

					</div>
					<div class="media-body input-wrapper align-self-center mr-2 " v-else>
						
						<textarea @keyup="ontype($event.target.value)" placeholder="message..." v-model='form.text' class="upload-text app-input-field">
						</textarea>

					</div>
					
					<div class="media-right align-self-center" >

						<!-- To Accept && Stop Recording For Verifying-->
						<span class="icon-wrapper p-1" v-if="record.isRecording && !typing">
							
							<a @click="stopRecording()" class="save-voice">
								<i class="fa fa-check app-fa"></i>
							</a>

						</span>

						<!-- For When The User Is Typing Or Stopped Recording, To Send The Text or Audio! -->

						<span class="icon-wrapper p-1" v-else-if="typing || !record.done || image.file"> <!-- || record.done -->
							
							<button class="send-btn" type="submit">
								
								<i class="fa fa-paper-plane app-fa"></i>

							</button>

						</span>
						<!-- Base Icons To Start Operations -->
						<span v-else>
						 <span class="icon-wrapper p-1">
						 	<clipper-upload style="display:inline-block" class="camera-btn" v-model="image.src">
						 	 <i class="fa fa-camera app-fa"></i>
						 	</clipper-upload>
						 </span>
						 <span class="icon-wrapper p-1">
						 	<a class="mic-btn" @click="toggleRecording()">
						 	 <i class="fa fa-microphone app-fa"></i>
						 	</a>
						 </span>
						</span>
						
					</div>

				</div>

			</form>

			<!-- Permission Overlay -->

			<!-- <div class="overlay-wrap" v-show="show">
				
				<div class="main-wrap card" v-show="show">
					
					<div class="card-header media">
						
						<Picture :user="user" :height="40" :width="40"></Picture>
						<div class="media-body pl-2 align-self-center">
							
							<span class="app-max-text">Microphone Permission</span>
							<span class="app-grey-text-lg">(@{{ user.getBasic().handle }})</span>

						</div>
						<div class="media-right align-self-center"></div>

					</div>
					<div class="card-body list-group">
						<div class="list-group-item">
							<center>
								<span class="app-small-text">You have to give Tunepik permission to use your microphone</span>
							</center>
						</div>
					</div>

				</div>

			</div> -->

		</div>
		<div class="grey-matter app-shared-post" v-else>
			
			<center>
				
				<span class="app-small-text" v-if="user.model.getActivity().youBlock">
					You Have Blocked
				</span>
				<span class="app-small-text" v-else>
					You Have Been Blocked By 
				</span>
				<span class="app-max-text">
					@{{ user.model.getBasic().handle }}
				</span>
			</center>

		</div>

	</div>
	
</template>

<script>

	import { mapGetters, mapActions, mapMutations } from 'vuex'
	import globs from '../../../tunepik/attack.js'
	import AudioBodyBuilder from '../postBuilders/AudioBodyBuilder'
	import LookUp from '../uploadBuilders/LookUp'
	
	export default {

		name 			: 'TextInput',
		data 			: () => ({
			screen : globs.app.isMobile,
			form 		: {
				text 	: '',
				media : null,
			},
			typing : false,
			recordText : '',
			show : false,
		}),
		components : {
			AudioBodyBuilder,
			LookUp
		},
		methods    : {

				...mapActions("recorder", ['init', 'toggleRecording', 'startRecording', 'stopRecording', 'cancelRecording']),
				...mapMutations("files", ['isSet', 'chosen', 'isFile', 'done', 'setText']),
				...mapActions("upload", ['userUpload']),
				sendMessage	 	: async function(data){

					 // Check If Still Recording
					 if(this.record.isRecording){

					 		await this.toggleRecording(); // Stop The Recording And Save The File!

					 		console.log({data});

					 		this.form.media = this.uploadedFile;

					 		this.userUpload(data);

					 		console.log({data});

					 }else{

					 	  this.form.media = this.uploadedFile;
					 		this.userUpload(data);

					 }

				},
				/*doneRecording : function(){

					this.stopRecording();

					this.cancelRecording();

				},*/
				ontype   : function(text){

					this.typing = text != '';

				},
				cancel   : function(){

					this.done(true);
					if(this.record.recorder) this.stopRecording();

				},

			},
			computed   : {


				...mapGetters("messages", ['message', 'user']),
				...mapGetters("recorder", ['record']),
				...mapGetters("files", ['image', 'checks', 'file', 'Text']),
				...mapGetters("upload", ['upload']),
				uploadedFile : function(){

						if(this.record.audio.file == null && this.image.file == null){

							console.log('NULLLLL')

						 	 return ''

						 }else{

						 	console.log('IS THERERERER')

						 	 return this.record.audio.file || this.image.file;

						 }

				},
				formDATA  : function(){

					return {

						text 	: this.form.text,
						media : this.form.media,
						url   : `/api/chats/messages/send/${this.user.model.getBasic().id}`,

					}

				},

			},
			mounted : function(){

				this.$nextTick(function(){
					this.init()
				})

				console.log(this.user)

			},
			watch 			 : {

				Text : function(text){
					this.form.text = text
				},
				'form.text' : function(text){
					if(text) this.setText(text)
				},
				'image.src' : function(val){

				 	/*this.$store.commit('files/isSet', val != "");
				 	this.$store.commit('files/chosen', val != "")*/

				 	this.isFile(val != "");
				 	this.done(val == "")
					this.isSet(val != "");
					this.chosen(val != "");

				},
				uploadedFile : function(val){

					console.log('CHANGED!');
					this.form.media = val;

					console.log(this.form);

				}

			}

	};

</script>

<style scoped type="text/css">
	

		@media only screen and (min-width: 700px){

			.fixed-bottom{
				border-top: .04em solid rgba(211, 211, 211, .175);
				right: 30px;
				left: 55.8%
			}

			.media-wrapper{
				position: fixed;
				bottom:0;
				left: 55.8%;
				right: 30px;
				height: 45px;
				width: wrap;
			}

		}

		.look-up-wrap{
			position: absolute;
			bottom: 46px;
			left: 10%;
		}

		@media only screen and (max-width: 700px){
			.media-wrapper{
				position: fixed;
				bottom:0;
				left: 0;
				right: 0;
				height:45px;
				width: 100%;
			}
		}

		.upload-text{
			width: 100%;
	    border: none;
	    font-size: 11pt;
	    float: left;
	    /*color: #63717f;*/
	    padding-left: 4px;
	    -webkit-border-radius: 5px;
	    -moz-border-radius: 5px;
	    border-radius: 2px;
	    outline : 0;
	    background-color: transparent;
		}

		.navbar{
			box-shadow: 0 0 0 0 transparent;
		}

		.app-fa{
			width: 19px;
			height: 19px;
		}

		.input-wrapper{
			border-radius: 15px;
		}

		.send-btn{
			border: 0;
			background-color: transparent;
		}

		.record-timer{
			padding-top: 3px;
			padding-bottom: 3px;
			padding-right: 3px;
			padding-left: 3px;
			width: 30%;
			border-radius: 10px;
			background-color: rgba(211, 211, 211, .4);
		}
		.fixed-bottom{
			height: 50px
		}

</style>