<template>

	<div class="wrapper">

		<Navigation>

			<div class="media-body">

				<div class="media full-width">
					<div class="media-left pl-1 pt-1 pb-1 align-self-center">

						<Icon :icon="'search'" class="icon-search" :width="18" :height="18" :color="theme.icons.color"></Icon>

					</div>

					<div class="media-body full-width align-self-center">
						<form @submit.prevent="redirect()">
							<input type="search" v-on:keyup="query = $event.target.value" name="search" class="xs-search app-search full-width" placeholder="search tunepik..." v-model="query" />
						</form>
					</div>

				</div>
				
			</div>
			<div class="media-left align-self-center">

				<router-link :to="{ name : 'profile', params : { username : model.getBasic().handle } }">
					<a @click="SET_PROFILE(model)">
						<Picture :height="30" :width="30" :user="model"></Picture>
					</a>
				</router-link>

			</div>

		</Navigation>

		<div class="space-large visible-large"></div>
		<div class="space-large visible-large"></div>
		<div class="wrap-users" v-if="search.data.users.found && queryType != 'posts'">

			<UserListBundler :message="search.data.users.message" :users="search.data.users.list" :showGrid="false"></UserListBundler>

		</div>

		<div class="posts-search-wrap">

			<PostsBundler :posts="results.posts" :type="results.type" :loading="results.loading" :list="results.list" :message="results.message"></PostsBundler>

		</div>

	</div>

</template>

<script type="text/javascript">

	import Navigation from '../mobile/root/Navigation'
	import UserListBundler from './userBuilders/UserListBundler'
	import PostsBundler from './postBuilders/PostsBundler'
	import globs from '../../tunepik/attack.js'
	import axios from 'axios'
	import { mapGetters, mapActions, mapMutations } from 'vuex'

	export default {

		name 	: "SearchResults",
		data  : () => ({

			query : '',

		}),
		components : {

			Navigation,
			UserListBundler,
			PostsBundler

		},
		methods : {

			...mapMutations('profile', ['SET_PROFILE']),
      ...mapActions('posts', ['getResults']),
			redirect : function(){

				if(this.query != '') {

					this.$router.push({ name : 'results', params : { term : this.query } })

				}

			},
		},
		computed : {

			...mapGetters('auth', ['model']),
			...mapGetters('find', ['search']),
			...mapGetters('tunepik', ['theme']),
      ...mapGetters('posts', ['results']),
			term : function(){
				return this.$route.params.term || 'empty'
			},
			queryType : function(){
				return this.$router.currentRoute.query.type || 'posts'
			},
      url : function(){
			  return `/api/posts/search/feed/${this.term}`
      }

		},
	  created(){

			if(this.term !== ''){

				this.query = this.term

			}

			this.getResults({url : this.url})

		},
		watch : {

			'$route.params.term' : function(term){

				if(term === '') return

				this.query = term

				this.getResults({url : this.url})

			},
			query : function(q, oldQ){

				if(q != oldQ) this.$route.params.term = q

			}

		}

	};

</script>

<style type="text/css" scoped>

	.search-wrapper{
		/*border : .04em solid rgba(211, 211, 211, .4);*/
		/*border-radius: 20px;*/
		position: relative;
		height: 35px;
		top: -2px;
	}

	.xs-search{
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

</style>
