import globs from '../../tunepik/attack.js'


export const state = {

		record : {

			permission 			: false,
			isRecording 		: false,
			done 						: true,
			recorder 				: null,
			audioContext 		: null,
			time 						: '00:00',
			interval 				: null,
			stream 					: null,
			audio  					: {

				file 		: null,
				url  		: '',

			}

		}

};

export const getters = {

	record 		: state => state.record,

};

export const mutations = {

	setPermission 		: (state, perm) => state.record.permission = perm,
	setRecording			: (state, recording) => state.record.isRecording = recording,
	setDone 					: (state, done) => state.record.done = done,
	setRecorder 			: (state, recorder) => state.record.recorder = recorder,
	setAudioContext   : (state, audioContext) =>  state.record.audioContext = audioContext,
	setTime 					: (state, time)	=> state.record.time = time < 10 ? `00:0${time}` : `00:${time}`,
	setInterval 			: (state, interval) => state.record.interval = interval,
	setStream 				: (state, stream) => state.record.stream = stream,
	setRecordedAudio  : (state, audio) => {

		  console.log(audio.url);
			state.record.audio.file = audio.file;
			state.record.audio.url  = audio.url;

	}

};

export const actions = {

		init 			: function({ commit, dispatch }){

			/* Initialize The Recorder! */
			try {

				window.AudioContext = window.AudioContext || window.webkitAudioContext;
		    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia;
		    window.URL = window.URL || window.webkitURL;

		    commit('setAudioContext', new AudioContext);

			} catch(e) {

				// statements
				console.log(e);

			}

			if(state.record.recorder == null && state.record.permission){
				dispatch('setRecorder');
			}

			navigator.getUserMedia({audio: true}, function(stream){

				commit('setStream', state.record.audioContext.createMediaStreamSource(stream));

				commit('setPermission', true);

				dispatch('setRecorder');

		} /* End Of Start User Media */, function(e){

				commit('setPermission', false);

			});

		} /* End Of Init */,
		setRecorder 			: function({ state, commit, dispatch }){

			if(state.record.stream != null){

				commit('setRecorder', new Recorder(state.record.stream));

			}else{

				console.log('Stream Is Null');

			}

		} /* End Of Set Record */,

		getRecorder 			: function({ state }){ return state.record.recorder; } /* End Of Get Recording */,

		getAudioContext 	: function({ state }){ return state.record.audioContext; } /* End Of Get AudioContext */,
		
		startRecording 		: function({ state, commit, dispatch }){

			commit('setRecordedAudio', { file : null, url : '' });

			dispatch('init') /* Initialize The Recorder ! Might Not Call This Function Here ! */

			/* Resume The Audio Context Due To A User Event! */
			state.record.recorder.context.resume().then(
				function(){

					console.log(state.record.recorder);
					state.record.recorder && state.record.recorder.clear(); /* Clear The Recorder */
					state.record.recorder && state.record.recorder.record(); /* Start Recording */

					commit('setRecording', true);

					if(state.record.isRecording){

						let time = 0;
						commit('setInterval', setInterval(function(){

							/* Voice Notes Should Only Be One Minute Or Less */
							if(time == 59){

								dispatch('stopRecording'); /* Stop The Recording! */

							}

								commit('setTime', time += 1); /* Set The Time */
								commit('setDone', false);

							}, 1000) /* For 1 Second */

						); /* End Of Commit */

					}

			}); /* End Of Context Resume! */

		} /* End Of Start Recording */,

		stopRecording 		: async function({ state, commit, dispatch }){

			if(state.record.interval != null) clearInterval(state.record.interval); /* Stop Timer From Incrementing! */

			state.record.recorder && state.record.recorder.stop(); /* Stop Recording */
			state.record.recorder.context.suspend();
			
			commit('setRecording', false);

			/* Create An Audio WAV File (blob) */
			state.record.recorder && await state.record.recorder.exportWAV(async function(audio){

				await commit('setRecordedAudio', { file : audio, url : URL.createObjectURL(audio) });

			}); /* End Of Export WAV */

			state.record.recorder && state.record.recorder.clear();

			commit('setRecorder', null);
			commit('setAudioContext', null);

		} /* End Of Stop Recording */,

		cancelRecording  : function({ state, commit, dispatch }){

			if(state.record.interval != null)  clearInterval(state.record.interval);

			commit('setDone', true);
			commit('setRecording', false);
			commit('setTime', 0);

			commit('setRecorder', null);
			commit('setAudioContext', null);

			commit('setRecordedAudio', { file : null, url : '' })


		} /* End Of Cancel Recording */,

		toggleRecording  : function({ state, commit, dispatch }){

			/* Check For Permission */
			if(state.record.permission){

				/* Check For Recording To Either Stop Recording Or Start Recording */
				if(state.record.isRecording){

					/* Stop Recording */
					dispatch('stopRecording');

				}else {
					
					/* Start Recording */
					dispatch('startRecording');

				}

			}else{

				console.log('Missing Microphone Permission');

			}

		} /* End Of Toggle Recording */,
 
};