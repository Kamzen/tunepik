import axios from 'axios'
import * as types from '../mutation-types'
import globs from '../../tunepik/attack.js'

export const state = {

	chat  : {

		 error : false,
		 message : '',
		 loading : false,
		 chats   : []

	},

	message : {

		 error : false,
		 message : '',
		 loading : false,
		 messages   : []

	},

	user   : {

		 error : false,
		 message : '',
		 loading : false,
		 model   : null,

	}

}

export const getters = {

	chat  	: state => state.chat,
	message : state => state.message,
	user    :  state => state.user,

}

export const mutations = {

	[types.CHAT_LOADING](state, loading){

		state.chat.loading = loading;

	},

	[types.FETCH_CHATS](state, data){

		state.chat.error = data.error
		state.chat.message = data.message
		
		if(!state.chat.error){

			data.chats.forEach(function(chat){

				state.chat.chats.push(new globs.model.chat(chat))

			});

		}

	},
	INSERT_CHAT : (state, data) => {

			data.chats.forEach(chat => {

				let chatModel = new globs.model.chat(chat)

				if(state.chat.chats.length > 0){

				let j = state.chat.chats.length - 1
				for(let i = 0; i < state.chat.chats.length; i++){

					// This Loop Show Search The Array from the front & back at the same time

					let frontCurrent = state.chat.chats[i] // current item from front trarvesal
					let backCurrent = state.chat.chats[j] // current item from back trarvesal

					// What If The Item Being Searched For Is In The Middle?
					// This Solves The Problem
					// Also Solves The 'One Item In An Array'
					if(frontCurrent.getBasic().id == backCurrent.getBasic().id && frontCurrent.getBasic().id == chatModel.getBasic().id) {
						state.chat.chats.splice(i, 1) // Remove This Current Entry
						state.chat.chats.unshift(chatModel) // Insert The New Entry At The Top Of Array

						break;

					}else if( frontCurrent.getBasic().id == backCurrent.getBasic().id) {

						// Means The Item Is Not In The Array, Should Insert
						state.chat.chats.unshift(chatModel)
						break;

					}; // To End The Loop Midway

					if(frontCurrent.getBasic().id == chatModel.getBasic().id){

						state.chat.chats.splice(i, 1) // Remove This Current Entry
						state.chat.chats.unshift(chatModel) // Insert The New Entry At The Top Of Array

						break;
					}

					if(backCurrent.getBasic().id == chatModel.getBasic().id){

						state.chat.chats.splice(j, 1) // Remove This Current Entry
						state.chat.chats.unshift(chatModel) // Insert The New Entry At The Top Of Array

						break;

					}

					j-- // Decrement J

				} // End Of For Loop

			}else{

				state.chat.chats.push(chatModel)

			} // End Of If Else

		}) // End Of ForEach


	},
	[types.MESSAGES_LOADING](state, loading){

		state.message.loading = loading

	},

	[types.FETCH_MESSAGES](state, data){

		state.message.error = data.error
		state.message.message = data.message
		
		if(!state.message.error){

			data.messages.forEach(function(message){

				state.message.messages.push(new globs.model.message(message))

			});

		}

	},

	[types.USER_LOADING](state, loading){

		state.user.loading = loading

	},

	MESSAGE_USER : function(state, data){

		state.user.error = data.error
		state.user.message = data.message
		state.user.model = data.user

	}

}

export const actions = {

	getChats : async function({ commit }) {

		 commit(types.CHAT_LOADING, true);

		 const { data } = await axios.get('/api/chats/conversations');

		 commit(types.FETCH_CHATS, {

		 		error  	: !data.list,
		 		message : data.message,
		 		chats   : data.chats

		 });

		 commit(types.CHAT_LOADING, false);

	},

	getMessages : async function({ commit, state }, handle, lastId = ''){

		commit(types.MESSAGES_LOADING, true);

		const { data } = await axios.get(`${globs.api}chats/messages/${handle}`);

		if(lastId == '' && state.message.messages.length > 0){

			commit(types.FETCH_MESSAGES, {

				error : data.error,
				message : data.message,
				messages : []

			});

		}

		commit(types.FETCH_MESSAGES, {

			error : data.error,
			message : data.message,
			messages : data.messages

		});

		commit(types.MESSAGES_LOADING, false);

	},

	getUser : async function({ commit }, handle){

		commit(types.USER_LOADING, true);

		const { data } = await axios.get(`${globs.api}chats/user/${handle}`);

		commit('MESSAGE_USER', {

			error : data.error,
			message : data.message,
			user    : new globs.model.user(data.user)

		});

		commit(types.USER_LOADING, false)

	}

}