<template>
	
	<div class="wrapper card">

		<form @submit.prevent="userUpload(form, uploaded)">

			<Navigation if="screen && checks.done">
				
				<div class="media-body align-self-center">
					
					<span class="app-max-text">
						{{ crumbs.header }}
					</span>

				</div>

				<div class="media-right p-0">
					
					<v-button nativeType="'submit'" :type="'primary'" class="btn-top">
						Reply
					</v-button>

				</div>

			</Navigation>
			<!-- <div class="card-header" v-else></div> -->
			<div class="card-body">

				<div class="visible-xs space-large"></div>
				<div class="visible-xs space-medium"></div>

				<div class="" v-if="comment == 'comment' || comment == 'share'">
					
					<PostSnippet :post="post" v-if="checks.done"></PostSnippet>

				</div>

				<WorkFiles :round="false" v-if="file"></WorkFiles>

				<UploadCover></UploadCover>

			</div>

			<div class="space-large c-large visible-xs"></div>
			<div class="space-large c-large visible-xs"></div>
			<div class="space-large c-large visible-xs"></div>
			<div class="space-large c-large visible-xs"></div>
		
			<div class="nav fixed-bottom record-bottom pr-2 pl-2 pb-1" v-if="screen && checks.done">

				<look-up class="look-up-wrap"></look-up>

					<div class="comment-box-wrapper mt-2 mb-2">
						
						<textarea class="comment-box" :placeholder="crumbs.placeholder" v-model="text"></textarea>

					</div>
				
				<div class="media pl-2 pr-2">
					
					<div class="media-left b-media align-self-center" >
						
						<a class="icon-rounder" @click="startRecording()" v-if="record.done">
							
							<!-- <Icon :icon="'mic'" :height="24" :width="24"></Icon> -->

							<i class="fa fa-microphone app-fa"></i>

						</a>

						<a class="icon-rounder" @click=""></a>

					</div>

					<div class="media-body align-self-center" v-if="record.done">
						


					</div>
					<div class="media-body align-self-center" v-else>
						
						<center>
							
							<div class="record-timer skeleton-shimmer">

								<div class="timers">
								
								<samp class="app-bold-text" style="color : red">
									RECORDING 
								</samp>

								</div>
								<div class="timers">
									
									<span class="app-bolder-text">{{ record.time }}</span>

								</div>

							</div>

						</center>

					</div>

					<div class="media-right b-media align-self-center" v-if="record.done">
						
						<clipper-upload v-model="image.src">

							<a class="icon-rounder">

							<Icon :icon="'gallery'" :height="20" :width="20"></Icon>

							</a>

						</clipper-upload>
					
					</div>
					<div class="media-right b-media align-self-center" v-else>
						
						<a class="icon-rounder" @click="cancelRecording()">
							
							<i class="fa fa-times app-fa"></i>

						</a>

					</div>

				</div>

			</div>

	 </form>
		
	</div>

</template>

<script type="text/javascript">

	import { mapGetters, mapActions, mapMutations } from 'vuex'
	import globs from '../../../tunepik/attack.js'
	import Navigation from '../../mobile/root/Navigation'
	import PostSnippet from '../snippets/PostSnippet'
	import WorkFiles from '../uploadBuilders/WorkFiles'
	import UploadCover from '../uploadBuilders/UploadCover'
	import LookUp from '../uploadBuilders/LookUp'
	
	export default {

		name : 'PostExtend',
		data : () => ({
			trim : globs.trim,
			screen : globs.app.isMobile,
			text : '',
			header : '',
			placeholder : '',
			url : '',
		}),
		components : {

			Navigation,
			WorkFiles,
			PostSnippet,
			UploadCover,
			LookUp

		},
		props : ['comment'],
		methods : {

			...mapActions("recorder", ['init', 'toggleRecording', 'startRecording', 'stopRecording', 'cancelRecording']),
			...mapActions("upload", ['userUpload']),
			...mapMutations("files", ['isSet', 'chosen', 'isFile', 'done', 'setText']),
			...mapMutations("tunepik", ['SNACK_BAR']),
			uploaded : function(response){
				if(!response.error) this.$router.push({ name : 'comment', params : { username : this.currentRoute.username, type : this.currentRoute.type, id : this.currentRoute.id } })

				this.SNACK_BAR({ isOpen : true, message : response.message, theme : response.error ? 'danger' : 'info' })

			}
		},
		computed : {

			...mapGetters('posts', ['focusPost']),
			...mapGetters('recorder', ['record']),
			...mapGetters("files", ['image', 'video', 'checks', 'file', 'Text']),
			...mapGetters("upload", ['upload']),
			uploadedFile : function(){
				 return this.record.audio.file || this.image.file || this.video.file || ''
			},
			post : function(){ 
				return this.focusPost
			},
			crumbs : function(){

				switch (this.comment) {
					case 'comment' :
							this.header = `Share @${this.trim(this.post.getBasic().handle, 8)}`
							this.placeholder = `Reply @${this.post.getBasic().handle}`
							this.url = `/api/upload/comment/${this.post.getPost().id}`
						break;

					case 'share' :
							this.header = `Reply @${this.trim(this.post.getBasic().handle, 8)}`
							this.placeholder = `Share @${this.post.getBasic().handle}`
							this.url = `/api/upload/share/${this.post.getPost().id}`
						break;

					case 'story' :
							this.header = 'Add Your Story' 
							this.placeholder = 'caption...'
							this.url = '/api/upload/story/'
						break;
					default:
						// statements_def
						break;
				}

				return {
					header 			: this.header,
					placeholder : this.placeholder,
					url 				: this.url,
					text 				: this.text
				}
			},
			form : function() {

				this.text = this.comment == 'comment' ? `@${this.post.getBasic().handle} ` : ''

				return {
					text : this.text,
					media : this.uploadedFile,
					url : this.crumbs.url
				}
			},
			currentRoute : function(){
				return this.$router.currentRoute.params
			},
			
		},
		watch 			 : {

			'Text' : function(text){
				this.text = text
			},
			text : function(text){
				 if(text) this.setText(text)
			},
			'image.src' : function(val){

			 	this.isFile(val != "");
			 	this.done(val == "")
				this.isSet(val != "");
				this.chosen(val != "");

			},
			uploadedFile : function(val){

				this.form.media = val;

			},
			'upload.data' : function(newData, oldData){

				if(newData == oldData) return

				this.SNACK_BAR({ isOpen : true, message : newData.message, theme : newData.error ? 'danger' : 'info' })

				if(this.comment == 'comment'){

					this.post.getStats().isCommented = newData.uploaded ? true : false

					if(!newData.error) this.$router.push({ name : 'comment', params : { username : this.currentRoute.username, type : this.currentRoute.type, id : this.currentRoute.id } })

				}else if(this.comment == 'share'){

					this.post.getStats().hasShared = newData.uploaded ? true : false

				}else if(this.comment == 'story'){}

			}

		},
		beforeMount : function(){

			if(this.comment == 'post' || this.comment == 'comment' || this.comment == 'share'){

				if(this.post == null){

						console.log(this.$router)

						 this.$router.push({ name : 'comment', params : { username : this.currentRoute.username, type : this.currentRoute.type, id : this.currentRoute.id } })

					}

			}

		}

	};

</script>

<style type="text/scss" scoped>

	.look-up-wrap{
			position: absolute;
			bottom: 46px;
			left: 10%;
		}


	.wrapper{

		overflow-y: auto;

	}

	.comment-box-wrapper{
		border-bottom : .04em solid rgba(211, 211, 211, .5);
		background-color: rgba(211, 211, 211, .175);
		height: 50px;
		width: 100%;
	}

	.comment-box:active{

		.comment-box-wrapper{
			border-bottom : #5bc0de;
		}

	}

	.comment-box{
		width: 100%;
		height: 50px;
    border: none;
    font-size: 11pt;
    float: left;
    color: #63717f;
    padding-left: 4px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 2px;
    outline : 0;
    background-color: transparent;
	}

  .record-bottom{

  	height: auto;
  	box-shadow: 0 0 0 0 transparent;
  	border: 0;

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
	    height: 43px;
	    margin-top: 40px;
	    margin-bottom: 10px;
    }

    .list-group-item{
    	border : 0;
    }

		.timers {
			display: inline-block;
		}

		.media,
		.media-body{
			width: 100%;
		}

		.b-media{
			padding: 10px;
			border-radius: 50%;
			background-color: rgba(211, 211, 211, .175); 
		}

		.btn-clear{
			background-color: transparent;
			border:0;
		}

		.card{
			border: 0;
		}

		.c-large{
			height: 100px
		}

		.app-fa.fa-microphone,
		.app-fa.fa-times{
			width: 20.5px;
			height: 20.5px;
		}

</style>