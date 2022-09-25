<template>

	<div class="wrapper">

		<Navigation style="background-color:transparent;z-index : 9999999">
			
			<div class="media-body align-self-center">
				
				<span class="app-max-text">
					Login With Selfie ID
				</span>

			</div>
			<div class="media-right"></div>

		</Navigation>

		<div class="video-view">
		
			<video class="video-tag" width="720" height="560" autoplay muted></video>

		</div>
		
		<div class="nav navbar fixed-bottom" style="background-color:transparent;z-index : 9999999;width:100%;">
			
			<div class="media" style="width:100%;">

				<div class="media-body align-self-center pr-2" style="width:100%;">

					<v-button :type="'primary'" :loading="loading" :block="true" @click.native="login()" v-if="face.isFace">Login</v-button>
					<center v-else>
						<span class="app-post-text" :style="{color : face.isFace ? theme.colors.green : theme.colors.red}">{{camera.message}}</span>
					</center>

				</div>

				<div class="media-right">
					<v-button :type="'danger'" @click.native="stopVideoFeed">
						cancel
					</v-button>
				</div>

			</div>

		</div>

	</div>

	
</template>

<script type="text/javascript">

	import Navigation from '../../components/mobile/root/Navigation'
	import { mapGetters, mapActions, mapMutations } from 'vuex'
	
	export default {

		name : 'FaceLogin',
		data : () => ({
			error : '',
			message : '',
		}),
		components : {
			Navigation
		},
		methods : {
			...mapActions('camera',['init', 'stopVideoFeed']),
			...mapMutations('camera', ['SET_CANVAS', 'SET_CONTEXT']),
			...mapMutations('tunepik', ['SNACK_BAR']),
			login : async function(){

			}
		},
		computed : {
			...mapGetters('camera', ['face', 'camera', 'video']),
			...mapGetters('tunepik', ['theme']),
		videoTag : async function(){
			  let tag = await this.$el.getElementsByTagName('video')[0]
				return tag
			},
			canvas : async function(){
				let canvas = await this.$el.getElementsByClassName('video-view')[0]
				return canvas
			},

		},
		mounted : function(){
			this.$nextTick( async () => {

				this.videoTag.then(tag => {
					tag.controls = false
					this.SET_CONTEXT('login')
					this.init(tag, 'startVideoFeed')
				})

				this.canvas.then(canvas => {this.SET_CANVAS(canvas)})

			})

		},
		beforeDestroy : function(){

			this.stopVideoFeed()

		}

	};

</script>

<style type="text/css">
	
	.wrapper,
	.video-tag{
		z-index: 9999 !important;
		position: fixed;
		top : 0;
		bottom: 0;
		left: 0;
		right: 0;
		width: 100%;
		height: 100%;
		overflow-y: auto;

	}

	canvas{
		position: absolute;
		z-index: 999999 !important;
	}

</style>