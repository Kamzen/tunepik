<template>

	<div class="upload-wrapper" v-show="upload.loading">
		
		<div class="loader background-animation"></div>

		<!-- <div style="width:100%;" class="navbar fixed-bottom upload-cover-nav bg-white">
			
			<div class="media" style="width:100%;">
				
				<div class="media-body align-self-center p0" style="width:100%;">
					
					<div class="progress">
						
						<div :style="{
						width : `${upload.percentage}%` 
					}" class="progress-bar progress-bar-striped progress-bar-animated bg-success">
						<span>
							{{ upload.percentage }}% Uploading...
						</span>
					</div>

					</div>

				</div>
				<div class="media-right align-self-center">
					<button class="btn btn-sm btn-danger">
						cancel
					</button>
				</div>

			</div>

		</div> -->

	</div>
	
</template>

<script type="text/javascript">

  import { mapActions, mapGetters } from 'vuex'

	export default {

		name  	: "UploadCover",
		method  : {

		},
		computed : {

			...mapGetters("upload", ['upload'])

		}


	};
	
</script>

<style type="text/css" scoped>

	@media only screen and (max-width: 700px){

		.upload-wrapper{

			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			height: 100%;
			width: 100%;
			z-index: 9999 !important;
			background-color: rgba(0, 0, 0, .175)

		}

	}

	.loader {
    left: 0;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 12;
}
.background-animation {
    height: 5px;
    background: #5bc0de -webkit-gradient(
    	linear, left top, right top, 
    	from(#5bc0de),
    	color-stop(#42aecf),
    	color-stop(#2ba8cf),
    	color-stop(#128fb5),
    	to(#086480)
    );
    background: #27c4f5 linear-gradient(
    	to right, 
    	#05730a, 
    	#0cf718, 
    	#5ef766, 
    	#b0f7b3, 
    	#4a914e
    );
    background-size: 500%;
    -webkit-animation: 2s linear infinite barprogress,.3s fadein;
    animation: 2s linear infinite barprogress,.3s fadein;
    width: 100%;
}

@-webkit-keyframes barprogress {
    0% {
        background-position: 0% 0
    }
    to {
        background-position: 125% 0
    }
}
@keyframes barprogress {
    0% {
        background-position: 0% 0
    }
    to {
        background-position: 125% 0
    }
}

@-webkit-keyframes fadein {
    0% {
        opacity: 0
    }
    to {
        opacity: 1
    }
}

@keyframes fadein {
    0% {
        opacity: 0
    }
    to {
        opacity: 1
    }
}
	
</style>