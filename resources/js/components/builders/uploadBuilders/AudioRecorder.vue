<template>


	<div class="wrapper">

		<center>
			<div class="list-group">
			
				<div class="list-group-item header-text">
					
					<span class="app-grey-text">
						Tap Icon To Start or Stop Recording
					</span>

				</div>
				<div class="list-group-item icon">
					
					<a class="record-wrapper-btn" v-on:click="toggleRecording()">

						<div class="icon-wrapper record-wrapper">
						
							<!-- <svg-vue icon="mic" class="app-icon mic-icon"></svg-vue> -->
							<i class="fa fa-microphone app-fa mic-icon"></i>

						</div>

					</a>

				</div>

				<div class="list-group-item" v-if="!record.done">
					
					<div class="record-timer skeleton-shimmer">

						<div class="timers">
						
						<samp class="app-bolder-text" style="color : red">
							RECORDING 
						</samp>

						</div>
						<div class="timers">
							
							<span class="app-bolder-text">{{ record.time }}</span>

						</div>

					</div>

				</div>
				<div class="list-group-item">
				   
				   <audio controls  v-if="record.audio.url != ''">
				   	<source :src="record.audio.url" >
				   </audio>

				</div>
					
				</div>

		</center>

		<div class="navbar fixed-bottom" v-if="!record.done">
			
			<div class="button-wrapper" style="width: 100%;" v-if="record.isRecording">
						
				<v-button :type="'primary'" class="mobile-share-control-btn send-post-xs yes" @click.native="stopRecording()">Stop Recording</v-button>
		    <v-button :type="'danger'" class="mobile-share-control-btn cancel-post-xs no" @click.native="cancelRecording()">Cancel</v-button>

			</div>
			<div class="button-wrapper" style="width: 100%" v-else>
				
				<button class="btn btn-info btn-block" v-on:click="cancelRecording()">Done</button>

			</div>

		</div>

	</div>
	


</template>


<script>

		import { mapGetters, mapActions } from 'vuex'
		import { clipperUpload } from 'vuejs-clipper'

		export default {

			name 				: "AudioRecorder",
			components  : {

			},
			data 				: function(){

				return {};

			},
			methods 		: {

				...mapActions("recorder", ['init', 'toggleRecording', 'startRecording', 'stopRecording', 'cancelRecording']),

			},
			computed 		: {

				...mapGetters("recorder", ['record'])

			},
			created(){

				this.init();

			}


		};

</script>

<style scoped>

		.mic-icon{

			width: 55px;
			height: 55px;

		}

		.record-timer{

			padding-top: 3px;
			padding-bottom: 3px;
			padding-right: 3px;
			padding-left: 3px;
			width: 30%;
			border-radius: 4px;
			background-color: rgba(211, 211, 211, .4);

		}
		.record-wrapper{
	    -webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, .175);
	    box-shadow: 0 2px 4px rgba(0, 0, 0, .175);
	    border-radius: 50px;
	    padding: 5px;
	    padding-top: 25px;
	    width: 30%;
	    height: 100px;
	    margin-top: 40px;
	    margin-bottom: 10px;
    }

    .list-group-item{

    	border : 0;

    }

		.timers {
			display: inline-block;
		}
	
</style>