import axios from 'axios'
import globs from '../../tunepik/attack.js'

export const state = {

		users 		: [],
		trends		: [],
		discover	: [],
		list 			: false,
		loading 	: false,
		error 		: false,
		message 	: '',

		follow   : {

			model 		: {},
			loading 	: false,
			message 	: 'Follow',
			error     : false,
			followers : 0,
			following : 0,

		}

		

}

export const getters = {

	Users 	: state => state.users,
	list 		: state => state.list,
	loading : state => state.loading,
	error 	: state => state.error,
	message : state => state.message,
	follow  : state => state.follow,

}

export const mutations = {


	setFollow : function(state, data){

		 state.follow.model = data.model;

		 state.follow.message = data.message;

		 state.follow.error = data.error;

		 state.follow.followers = data.model.getActivity().followers;

		 state.follow.following = data.model.getActivity().follows;

	},

	setFLoading(state, loading){

		state.follow.loading = loading

	},

	setSuggests : function(state, data){

		 state.users = data.users;

		 state.list = data.list;

		 state.error = data.error;

		 state.message = data.message;

	},

	setLoading : function(state, loading){

		state.loading = loading;

	}

}

export const actions = {

	  setFollowState : async function({ commit }, Model){

	  	 commit('setFollow', {

	  	 	 model    : Model,
	  	 	 message  : Model.getActivity().following ? 'Following' : 'Follow' ,
	  	 	 error 		: false

	  	 });

	  },

	  followUser     : async function({ commit }, Model){

	  	 Model.loading = true;

	  	 console.log(Model);

	  	 let response = await axios.post(`${globs.api}follow/followuser/${Model.getBasic().id}`);

	  	 let data = globs.resp(response);

	  	 Model.loading = false;

	  	 Model.getActivity().followers = data.followers;
	  	 Model.getActivity().follows   = data.following;
	  	 Model.getActivity().following = data.follow;

	  	 	  commit('setFollow', {

			  	 	 model    : Model,
			  	 	 message  : data.message,
			  	 	 error 		: data.error

			  	 });

	  },

		getSuggestions : async function({ commit }){

			commit('setLoading', true);

			let response = await axios.get(`${globs.api}follow/suggests`);

			let data = globs.resp(response);

			commit('setLoading', false);

			if(data.error){

				commit('setSuggests', );

			}else {
					
					if(!data.list){

						commit('setSuggests', {
							users : [],
							error : false,
							list  : data.list,
							message : data.message
						})

					}else{

						let List = [];

						data.follow_list.forEach((UserData, index) => {

							List.push(new globs.model.user(UserData));

						});

						commit('setSuggests', {
							users : List,
							error : data.error,
							list  : data.list,
							message : data.message
						});

					}

			}


		}


}