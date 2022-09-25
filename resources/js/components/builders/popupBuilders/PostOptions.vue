<template>

	<div class="list-group">

		<!-- Show Likers -->
		<a class="list-group-item list-group-item-action b-under">

			<router-link :to="{ name : 'list', params : { username : post.getBasic().handle, id : post.getPost().id, type : 'likers' } }">
				<div class="media">
					<div class="align-self-center">
						<i class="fa fa-heart app-fa"></i>
					</div>
					<div class="media-body ml-2">
						<span class="app-small-text">
							Likes
						</span>
					</div>
				</div>
			</router-link>

		</a>

		<!-- Show Commenters -->
		<a class="list-group-item list-group-item-action b-under">
			<router-link :to="{ name : 'list', params : { username : post.getBasic().handle, id : post.getPost().id, type : 'commenters' } }">
				<div class="media">
					<div class="align-self-center">
						<Icon :icon="'comment'" :height="20" :width="20"></Icon>
					</div>
					<div class="media-body ml-2">
						<span class="app-small-text">
							Comments
						</span>
					</div>
				</div>
			</router-link>
		</a>

		<a @click="deletePost()" class="list-group-item list-group-item-action b-under" v-if="post.getActivity().me">
			<div class="media">
				<div class="media-left align-self-center">
					<i class="fa fa-trash app-fa"></i>
				</div>
				<div class="media-body ml-2 align-self-center">
					Delete
				</div>
				<spinner class="align-self-center" v-if="deleter.loading"></spinner>
			</div>
		</a>

		<!-- Go To Full Post Page -->
		<a class="list-group-item list-group-item-action b-under">
			<router-link :to="{ name : 'comment', params : {username : post.getBasic().handle, id : post.getPost().id} }" >
				<div class="media">
					<div class="align-self-center">
					 <i class="fa fa-external-link-square app-fa"></i>
					</div>
					<div class="media-body ml-2 align-self-center">
						<span class="app-small-text">
							Open Full Post
						</span>
					</div>
				</div>
			</router-link>
	  </a>

	  <a class="list-group-item list-group-item-action b-under" @click="SET_REPORT({obj : post, type :'post'})" v-if="!post.getActivity().me">
      <router-link :to="{ name : 'edit.report', params : { type : 'post' } }">
			<div class="media">
				<div class="media-left align-self-center">
					<i class="fa fa-ban app-fa"></i>
				</div>
				<div class="media-body ml-2 align-self-center">
					<span class="app-small-text">Report</span>
				</div>
			</div>
      </router-link>
		</a>

		<!-- Show Follow Button And Block Button -->
		<div class="list-group-item b-under">
			<FollowButton :user="post" :classes="'btn-block input-block-level btn-sm'"></FollowButton>
		</div>

	</div>

</template>

<script>

	import FollowButton from '../userBuilders/FollowButton'
	import {mapMutations} from 'vuex'
	import axios from 'axios'

	export default {

		name 			 : "PostOptions",
		data 			 : () => ({
			deleter : { 
				loading : false 
			}
		}),
		components : {
			FollowButton
		},
		props 		 : ['post'],
		methods 	 : {
			...mapMutations('report', ['SET_REPORT']),
			...mapMutations('tunepik', ['SNACK_BAR']),
			deletePost : function(){

				this.deleter.loading = true
				axios.get(`/api/react/delete/post/${this.post.getPost().id}/?type=post`)
						 .then( ({data}) => {

						 	this.SNACK_BAR({ isOpen : true, message : data.message, theme : 'primary' })
						 	this.post.getPost().type = data.deleted ? 'deleted' : this.post.getPost().type

						 	this.deleter.loading = false

				}).catch(e => {
					console.log(e)
				})

			}
		}
	};

</script>

<style scoped>

	.b-under{
		border: 0;
		margin-bottom: .5px;
	}

	.no-border{
		border : 0;
	}

	.media{
		width: 100%;
	}

	@media only screen and(max-width: 700px){

		.list-group{

			border-radius: 8px;

		}

	}

</style>
