<template>

		<div class="wrapper">

			<Navigation v-if="!checks.done">
				
				<div class="media-body align-self-center">
						<span class="app-max-text">
							Edit
						</span>
				</div>
				<div class="media-right align-self-center">
					
					<a class="rotate" @click="rotate()">

						<span class="app-post-text">rotate</span>

						<!-- <i class="fa fa-rotate-right app-fa"></i> -->

					</a>

				</div>

			</Navigation>
			

			<div class="image-worker">

				<div class="work-image" :style="{position : 'relative', top : round ? '180px' : '60px'}" v-if="!checks.done">

					<!-- <div class="visible-xs space-large"></div>
					<div class="visible-xs space-large"></div>
					<div class="visible-xs space-large"></div> -->
					
					<clipper-fixed 
								class="basic clipper-fixed"
								preview="fixed-preview" 
								:round="round" 
								:src="image.src" 
								ref="clipper"
								:rotate="image.rotation"
								:ratio="imgRatio"
								:area="100"></clipper-fixed>

					<!-- <center>
						
						<div class="space-medium">
							
							<clipper-range v-model="image.rotation" style="max-width:300px" :min="0" :max="360"></clipper-range>

						</div>

					</center> -->

				</div>
				<div class="space-wrap" v-if="round">
					<div class="visible-xs space-large"></div>
					<div class="visible-xs space-large"></div>
					<div class="visible-xs space-large"></div>
				</div>
				<div class="show-image p-2">
					
						<div class="app-image-body" v-if="checks.done && image.file != null">
							
							<img :src="image.url" class="img-fluid" :class="[round ? 'rounded-circle' : 'rounded']" />

						</div>
						<div class="app-media app-video main-wrapper" v-if="video.file && video.url != ''">
							
							<video controls class="app-media app-video main-wrapper">
								
								<source :src="video.url">

							</video>

						</div>

						<!-- <div class="space-medium"></div> -->
						<div class="media mb-2">
					  	<div class="media-body"></div>
					  	<div class="media-right pr-3 pt-3">
					  		
					  		<a @click="removeAll" class="remove">
					  				
					  				<i class="fa fa-times app-fa"></i>

					  		</a>

					  	</div>
					  </div>

				</div>

			</div>

			<div class="navbar fixed-bottom container" v-if="!checks.done">
				

				<v-button class="mobile-share-control-btn send-post-xs yes" @click.native="crop()" :type="'primary'">
					Done
				</v-button>
				<v-button :type="'danger'" class="mobile-share-control-btn cancel-post-xs no" @click.native="removeAll()">
					Cancel
				</v-button>

			</div>

		</div>
	
</template>

<script type="text/javascript">

	import { mapGetters, mapActions, mapMutations } from 'vuex'
	import { clipperFixed } from 'vuejs-clipper'
	import Navigation from '../../mobile/root/Navigation'
	
	export default {

		name 		: 'WorkFiles',
		components : {

			Navigation

		},
		props   : ['round', 'ratio'],
		methods : {

			...mapActions("files", ['crop', 'removeAll']),
			...mapMutations("files", ['clipper', 'isSet']),
			rotate : function(){

				if(this.image.rotation >= 360) this.image.rotation = 0;
				else {
					
					this.image.rotation += 90

				}

			},

		},
		computed : {

			...mapGetters("files", ['image', 'checks', 'file', 'video']),
			cropper : function(){

				return this.$refs.clipper;

			},
			imgRatio : function(){

				return this.round ? (4/3) : (this.ratio ? this.ratio : (4/3))

			}

		},

		mounted : function(){

			this.$nextTick(function(){

				if(this.image.src != ""){

					console.log(this.cropper);

					this.clipper(this.cropper);

				}

			});

		},

		watch : {

			'checks.done' : function(val){

				 if(val == false){

				 	this.clipper(this.cropper);

				 }

			}

		}

	};
	
</script>

<style type="text/css" scoped>
	
	.app-image-body,
	.work-image{

		/*border : .05em solid rgba(211, 211, 211, .4);*/

	}

	.work-image{

		position: relative;
		top: 60px;

	}

	@media only screen and (max-width: 700px){

		.show-image{

		}

	}

</style>