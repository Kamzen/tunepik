import axios from 'axios'
import globs from '../../tunepik/attack.js'




export const state = {

	user : {

		loading : false,
		message : 'Heyy, Im Empty',
		error   : false,
		model   : null,
		analyse : null,
		posts   : null

	},

	posts : {

		loading : false,
		message : '',
		error   : false,
		userposts   : [],
		list    : false

	},
	liked : {

		loading : false,
		message : '',
		error 	: false,
		likedposts : [],
		list 		: false

	},
	follows : {

			loading : false,
			list 		: false,
			error 	: false,
			message : '',
			users 	: []

	},
	grid 	: {

		loading 	: false,
		list 			: false,
		error 		: false,
		message   : '',
		posts 		: []

	},
	profiles : {

		users : []

	},
	userSideProfile : {
		show : false
	}
}

export const getters = {

	profile : state => state.user,
	posts   : state => state.posts,
	liked 	: state => state.liked,
	follows : state => state.follows,
	grid 		: state => state.grid,
	profiles : state => state.profiles,
	userSideProfile : state => state.userSideProfile,

}

export const mutations = {


	setPostsLoading : (state, loading) => (state.posts.loading = loading),

	setPosts        : (state, data) => {

		 state.posts.message = data.message;

		 state.posts.error = data.error;

		 state.posts.list = data.list;

		 data.posts.forEach((post) => {

		 	state.posts.userposts.push(new globs.model.post(post))

		 })

	},

	setLikedLoading : (state, loading) => state.liked.loading = loading,

	setLiked 				: (state, data) => {

		state.liked.message = data.message;

		 state.liked.error = data.error;

		 state.liked.list = data.list;

		 data.posts.forEach( function(PostItem, index) {

		 			state.liked.likedposts.push(new globs.model.post(PostItem));

		 });

	},

	setUserLoading : (state, loading) => (state.user.loading = loading),

	setProfile 		 : (state, data) => {

		state.user.message = data.message;

		state.user.error = data.error;

		state.user.model = data.model;

	},
	setFollowsLoading : (state, loading) => state.follows.loading = loading,

	setFollows 				: (state, data) => {

		state.follows.error = data.error;
		state.follows.list 	= data.list;
		state.follows.message = data.message;

		state.follows.users = [];

				data.users.forEach( function(UserItem, index) {

					state.follows.users.push(new globs.model.user(UserItem));

				});

	},

	setGridLoading 		: (state, loading) => state.grid.loading = loading,
	setGrid 					: (state, data)		 => {

		state.grid.error 			= data.error;
		state.grid.list 			= data.list;
		state.grid.message 		= data.message;

		 if(data.new){

		 	 state.grid.posts = [];

		 }

		 if(data.posts.length == 0) return;

		 data.posts.forEach(function(postItem, index){

		 	 state.grid.posts.push(postItem);

		 });

	},
	SET_PROFILE : (state, profile) => {


		// state.user.model = profile

			if(state.profiles.users.length == 0) state.profiles.users.push(profile)
				else {

					var isFound = false

					for(let i = 0; i < state.profiles.users.length; i++){

						if(state.profiles.users[i].getBasic().id == profile.getBasic().id){

							isFound = true
							break;

						}

					}

					if(!isFound) state.profiles.users.push(profile)
				
				}

	},
	SIDE_PROFILE : (state, args) => state.userSideProfile.show = args.show,

}

export const actions = {

	makeGrid 				: async function({ dispatch, state, commit  }, type){

		commit('setGridLoading', true);

		  if(!state.posts.list){
		  	await dispatch('getUserPosts', {url : `/api/posts/user/${state.user.model.getBasic().id}/`});
		  }

			if(type == 'all'){

				commit('setGrid', {

					error 		: state.posts.error,
					list 			: state.posts.list,
					message 	: !state.posts.list ? `@${state.user.model.getBasic().handle} Has Not Uploaded Anything` : `@${state.user.model.getBasic().handle}'s Grid Posts`,
					posts 		: state.posts.userposts,
					new 			: true

				});

				commit('setGridLoading', false);

				return;

			}

			let gridposts =  [];

			if(state.posts.list){

				state.posts.userposts.forEach(function(post, index){

					console.log(post);

					if(post.getPost().type == type){

						gridposts.push(post);

					}

				});

			}

			console.log(gridposts);

			commit('setGrid', {

				error 		: gridposts.length == 0,
				list 			: gridposts.length > 0,
				message 	: gridposts.length == 0 ? `@${state.user.model.getBasic().handle} Has Not Uploaded Any ${type}s` : `@${state.user.model.getBasic().handle}'s ${type}s`,
				posts 		: gridposts

			});

			commit('setGridLoading', false);

	},

	getFollowsUsers : async function({ state, commit }, form){

			if(!form.lastId) commit('setFollowsLoading', true);

			if(state.user.model.getBasic().id == null){

				commit('setFollows', {

			 			message : 'Users Not Found',
			 			list    : false,
			 			error   : true,
			 			users   : []

			 		});

				commit('setFollowsLoading', false);

			}else {

					let response = await axios.get(form.lastId ? `${form.url}?last_id=${form.lastId}` : form.url);

					let data = globs.resp(response);

					if(data.error){

						commit('setFollows', {

				 			message : data.message,
				 			list    : false,
				 			error   : true,
				 			users   : []

				 		});

				 		commit('setFollowsLoading', false);

					}else{

						commit('setFollows', {

				 			message : data.message,
				 			list    : data.list,
				 			error   : data.list ? false : true,
				 			users   : data.list ? data.follow_list : []

				 		});

				 		commit('setFollowsLoading', false);

					}

			}

	},

	getLikedPosts : async function({ state, commit }, form){

			if(!form.lastId) commit('setLikedLoading', true);

			if(state.user.model.getBasic().id == null){

					commit('setLiked', {

			 			message : 'User Not Found',
			 			list    : false,
			 			error   : true,
			 			posts : []

			 		});

			 		commit('setLikedLoading', true);

			}else{

				let response = await axios.get(form.lastId ? `${form.url}?last_id=${form.lastId}` : form.url);

				let data = globs.resp(response);

					if(data.error){

						commit('setLiked', {

				 			message : data.message,
				 			list    : false,
				 			error   : data.error,
				 			posts : []

				 		});

				 		commit('setLikedLoading', false);

					}else{

						commit('setLiked', {

				 			message : data.message,
				 			list    : data.list,
				 			error   : data.list ? false : true,
				 			posts 	: data.list ? data.posts : []

				 		});

				 		commit('setLikedLoading', false);

					}

			}

	},

	getUserPosts  : async function({ commit }, form){

		 if(!form.lastId) commit('setPostsLoading', true);

		 console.log(form.url)

		 const {data} = await axios.get(form.lastId ? `${form.url}?last_id=${form.lastId}` : form.url);

		 	if(data.error){

		 		commit('setPosts', {

		 			message : data.message,
		 			list    : data.list,
		 			error   : data.error,
		 			posts : []

		 		});

		 		commit('setPostsLoading', false);

		 	}else{

		 		if(data.list){


		 			commit('setPosts', {

			 			message : data.message,
			 			list    : data.list,
			 			error   : data.error,
			 			posts 	: data.posts

			 		});

			 		commit('setPostsLoading', false);

		 		}else{

		 			commit('setPosts', {

			 			message : data.message,
			 			list    : data.list,
			 			error   : true,
			 			posts : []

			 		});

			 		commit('setPostsLoading', false);

		 		}

		 	}

	},

	setUserProfile : function({commit}, Model){

		commit('setProfile', {

			message : 'Profile Found',
			error   : false,
			model 	: Model

		});

	},

	getUserProfile : async function({commit}, username){

		commit('setUserLoading', true);

		let response = await axios.get(`${globs.api}profile/${username}`);

		let data = globs.resp(response);

		console.log(data);

				if(data.error){

					commit('setProfile', {

						message : 'Profile Error',
						error   : true,
						model 	: null

					});

					commit('setUserLoading', false);

				}else{

					 let profile = new globs.model.user(data.user)

					 commit('setProfile', {

						message : 'Profile Found',
						error   : false,
						model 	: profile,

					});

					 commit('SET_PROFILE', profile)

					 commit('setUserLoading', false);

				}

	},
	MAIN_USER  : function({ state, commit, dispatch}, handle){

		if(state.profiles.users.length === 0) return false

	  for(let i = 0; i < state.profiles.users.length; i++){

	  	if(state.profiles.users[i].getBasic().handle === handle){

	  		dispatch('setUserProfile', state.profiles.users[i])

	  		return true

	  	}

	  }

		return false

	},
	purge : function({commit}){

		commit('setPosts', {
			message : '',
 			list    : false,
 			error   : true,
 			posts : []
		})

		commit('setLiked', {
			message : '',
 			list    : false,
 			error   : true,
 			posts : []
		})

	}

}
