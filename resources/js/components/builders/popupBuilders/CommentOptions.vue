<template>

	<div class="list-group">
		
		<a class="list-group-item list-group-item-action b-under" @click="SET_REPORT({obj : comment, type :'comment'})" v-if="!comment.getActivity().me">
      <router-link :to="{ name : 'edit.report', params : { type : 'comment' } }">
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

		<a @click="deleteComment()" class="list-group-item list-group-item-action b-under" v-if="comment.getActivity().me || comment.getActivity().me">
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

		<div class="list-group-item">
			<FollowButton :user="comment" :classes="'btn-block input-block-level btn-sm'"></FollowButton>
		</div>

	</div>
	
</template>

<script type="text/javascript">

	import { mapMutations } from 'vuex'
	import FollowButton from '../userBuilders/FollowButton'
	import axios from 'axios'
	
	export default {

		name : "CommentOptions",
		data : () => ({
			deleter : { 
				loading : false
			}
		}),
		components : {
			FollowButton
		},
		props : ['comment'],
		methods : {
			...mapMutations('report', ['SET_REPORT']),
			...mapMutations('tunepik', ['SNACK_BAR']),
			deleteComment : function(){

				this.deleter.loading = true

				axios.get(`/api/react/comment/${this.comment.getPost().id}/?type=comment`)
						 .then(({data}) => {

						 	this.SNACK_BAR({ isOpen : true, message : data.message, theme : 'primary' })
						 	this.comment.getPost().type = data.deleted ? 'deleted' : this.comment.getPost().type

						 	this.deleter.loading = false

						 }).catch(e => {
						 	console.log(e)
						 })

			}

		}

	};

</script>

<style type="text/css" scoped>
	
	.list-group-item{
		border: 0;
		border-bottom: .04em solid rgba(211, 211, 211, .125);
	}

</style>