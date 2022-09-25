import axios from 'axios'
import globs from '../../tunepik/attack.js'


export const state = {

	search : {

		loading  : false,
		query 	 : '',
		error 	 : false,
		message  : '',
		data 		 : {

			tags  : {

				found  : false,
				tag 	 : false,
				message : '',
				hashes : []

			},
			words : {

				found  : false,
				word 	 : false,
				message : '',
				list   : [],

			},
			users : {

				found  : false,
				user 	 : false,
				message : '',
				list 	 : []

			}

		}

	}

};

export const getters = {

	search : state => state.search,

};

export const mutations = {

	setLoading : (state, loading) => state.search.loading = loading,
	setQuery 	 : (state, q) => state.search.query = q,
	setSearchUsers : (state, data) => {

		state.search.data.users.found = data.found;
		state.search.data.users.user 	 = data.user;
		state.search.data.users.message = data.message;

		state.search.data.users.list = [];

		data.users.forEach((userItem, index) => {

			state.search.data.users.list.push(new globs.model.user(userItem));

		});


	},
	setSearchTags  : (state, data) => {

		state.search.data.tags.found = data.found;
		state.search.data.tags.tag 	 = data.tag;
		state.search.data.tags.message = data.message;

		state.search.data.tags.hashes = [];

		data.hashes.forEach((hashItem, index) => {

			state.search.data.tags.hashes.push(new globs.model.tag(hashItem));

		});

	},
	setSearchWords : (state, data) => {

		state.search.data.words.found = data.found;
		state.search.data.words.word 	 = data.word;

		state.search.data.words.list = data.list

	},
	setSearch  : (state, data) => {

		state.search.error      = data.error;
		state.search.message    = data.message;

	}

};

export const actions = {

	getSearch			: async function({ commit }, q){

		commit('setQuery', q);
		commit('setLoading', true);

		let form = new FormData();
		form.append('q', q);

		let response = await axios.post(`${globs.api}search`, form);

		let data = globs.resp(response);

			if(data.error){

				commit('setSearch', { error : data.error, message : data.message });
				commit('setLoading', false);

			}else{

				commit('setSearch', { error : data.error, message : data.message });

				commit('setSearchTags', {

					found 	: data.hashtags.found,
					tag 		: data.hashtags.hashes,
					hashes  : data.hashtags.found ? data.hashtags.trends : [],
					message : data.hashtags.message

				});

				commit('setSearchWords', {

					found : data.words_used.found,
					word 	: data.words_used.words,
					message : data.words_used.message,
					list 	: data.words_used.found ? data.words_used.list : {}

				});

				commit('setSearchUsers', {

					found 			: data.users.found,
					user 				: data.users.users,
					message 	  : data.users.message,
					users 				: data.users.found ? data.users.list : []

				});

				commit('setLoading', false);

			}

	}

};