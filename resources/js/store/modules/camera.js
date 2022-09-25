import axios from 'axios'


export const state = {

	  camera : {
	  	permission : true,
	  	loading    : false,
	  	message    : ''
	  },
		video : {

			isRecording : false,
			interval : null,

		},
		face : {
			descriptor : null,
			detections  : null,
			isFace      : false,
		},
		mathFaces : {
			labels : [],
			descriptors : [],
			loading : false,
			error : false,
			message : ''
		},
		tag : null,
		canvas : null,
		context : null

}

export const getters = {
	camera : state => state.camera,
	video  : state => state.video,
	face 	 : state => state.face,
	mathFaces : state => state.mathFaces
}

export const mutations = {
	SET_TAG : (state, tag) => state.tag = tag,
	SET_CANVAS : (state, canvas) => state.canvas = canvas,
	SET_FACE   : (state, face) => {
		state.face.isFace = face.isFace
		state.face.descriptor = face.detections ? face.detections.descriptor.toString() : null
		state.face.detections = face.detections
	},
	SET_LOADING : (state, loading) => state.camera.loading = loading,
	SET_MESSAGE : (state, message) => state.camera.message = message,
	SET_INTERVAL : (state, int) => state.video.interval = int,
	SET_CONTEXT : (state, cxt) => state.context = cxt,
}

export const actions = {

		init : function({ dispatch, commit }, tag, method){

			commit('SET_TAG', tag)
			commit('SET_LOADING', true)
			commit('SET_MESSAGE', 'Initializing...')

			Promise.all([

				faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
			  faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
			  faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
			]).then(dispatch('startVideoFeed'))
				.catch(function(e){
					console.log('Models Not Loaded! : ' + e)
				})

		},
		startVideoFeed : function({ commit, state, dispatch }){

			navigator.getUserMedia({ video : { aspectRatio : 16/9 } }, stream => {

				state.tag.srcObject = stream
				commit('SET_LOADING', false)
				commit('SET_MESSAGE', 'Recognizing...')

				if(state.context == 'login'){
					dispatch('matcher')
				}else if(state.context == 'update'){
					dispatch('detect')
				} // Call the detection method

			}, err => console.error(err))

		}, // End Of startVideoFeed
		stopVideoFeed : function({ commit, state }){

			let tracks = state.tag.srcObject.getTracks()

			tracks.forEach( function(track) {

				track.stop()

			});

			commit('SET_TAG', null)
			commit('SET_CANVAS', null)
			clearInterval(state.video.interval)

		}, // End Of StopVideoFeed
		detect : function({ commit, state, dispatch }){

			// On Playing Start Detecting Faces
			state.tag.addEventListener('playing', () => {

				// Local Video Var!
				let video = state.tag

				const canvas = faceapi.createCanvasFromMedia(video)
  			state.canvas.insertBefore(canvas, video) // HUGE REDUNDANCY... REQUIRES FIX... CANVAS INSIDE CANVAS REALLL??
  			const displaySize = { width: video.width, height: video.height }

 			  faceapi.matchDimensions(canvas, displaySize)

 			  // Detect Face At An Interval
 			  let detectInterval = setInterval(async () => {

 			  	  // Get Detections
				    const detections = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor()
				    console.log(detections)
				    // if(detections.length > 0) console.log(detections.descriptor)

				    // Draw Detections On Top Of Face, Atleast That was the plan
				    /*const resizedDetections = faceapi.resizeResults(detections, displaySize)
				    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
				    faceapi.draw.drawDetections(canvas, resizedDetections)
				    faceapi.draw.drawFaceLandmarks(canvas, resizedDetections)*/

				    commit('SET_MESSAGE', detections ? `Recognizing face...` : `No Face Detected` )

				    // SET FACE RESULTS TO STORE
				    commit('SET_FACE', {
				    	isFace : detections != undefined,
				    	detections : detections
				    })


				  }, 1500)

 			  commit('SET_INTERVAL', detectInterval)

			}) // End Of event Listener

		}, // End Of Detect
		matcher : async function({ state, commit, dispatch }){

			try {
				
       	state.tag.addEventListener('playing', async () => {

       		let video = state.tag

       		const labeledFaceDescriptors = await dispatch('getMathFaces')
	       	const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors, 0.6)
       		const displaySize = { width: video.width, height: video.height }

       		let detections, resizedDetections, results

       		let matcherInterval = setInterval(async () => {

       			 detections = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor()

    				 if(detections) resizedDetections = faceapi.resizeResults(detections, displaySize)
    				  
    				 if(resizedDetections )  results = faceMatcher.findBestMatch(resizedDetections.descriptor)


    				commit('SET_MESSAGE', detections ? `Recognizing face...` : `No Face Detected` )

				    // SET FACE RESULTS TO STORE
				    commit('SET_FACE', {
				    	isFace : detections != undefined,
				    	detections : detections
				    })

       		}, 1500)

       		commit('SET_INTERVAL', matcherInterval)

       	})


			} catch(e) {
				// statements
				console.log(e);
			}

			console.log('last line')

		}, // End Of Matcher
		getMathFaces : async function(){
			 const { data } = await axios.post('/api/selfie/login')

			 if(data.error || data.faces.length == 0){

			 	 // Show Error To Screen

			 }else{

			 	  let labeledFaces = data.faces.map(face => {
			 				let d = new Float32Array(face.face_map.split(','))
			 				return new faceapi.LabeledFaceDescriptors(face.user_athandle, [d])
			 			
			 		})

			 		return Promise.all(

			 			 labeledFaces

			 		) // End Of Promise

			 } // End Of Else

		} // End Of getMathFaces

}