import axios from 'axios'
import globs from '../../tunepik/attack.js'


export const state = {

	userspostslist : {
		error   : false,
		loading : false,
		list 		: false,
		message : '',
		users 	: []
	},

}

export const getters = {

	userspostslist : state => state.userspostslist,

}

export const mutations = {

	setListLoading : (state, loading) => state.userspostslist.loading = loading,
	setUserList 	 : (state, data) => {

		state.userspostslist.error 	= data.error;
		state.userspostslist.users 	= data.list;
		state.userspostslist.message = data.message;

		state.userspostslist.users = [];

		data.userslist.forEach((UserItem, index) => {

			state.userspostslist.users.push(new globs.model.user(UserItem.user_info));

		});

	},

}

export const actions = {

	getPostLists : async function({ commit }, url){

		commit('setListLoading', true);

		let response = await axios.get(url);

		console.log(response);

		let data = globs.resp(response);

			if(data.error){

				commit('setUserList', {

					 error 		: data.error,
					 message  : data.message,
					 list 		: false,
					 userslist : []

				});

				commit('setListLoading', false);

			}else{

				commit('setUserList', {

					 error 		: data.list ? false : true,
					 message  : data.message,
					 list 		: data.list,
					 userslist : data.list ? data.users : []

				});

				commit('setListLoading', false);

			}

	}

}