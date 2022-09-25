import axios from 'axios'
import globs from '../../tunepik/attack.js'



export const state = {

	notifications : {

		error 	: false,
		list  	: false,
		message : 'No Notifications',
		loading : false,
		notifs 	: []

	},

}


export const getters = {

	notifications : state => state.notifications,

}

export const mutations = {

	setNotifLoading  : (state, loading) => state.notifications.loading = loading,
	setNotifications : function(state, data){

		state.notifications.list 		= data.list;
		state.notifications.error 	= data.error;
		state.notifications.message = data.message;

		data.notificationsList.forEach((NotifItem, index) => {

			state.notifications.notifs.push(new globs.model.notification(NotifItem));

		});

	}

}


export const actions = {

	getNotifications : async function({ commit }){

		commit('setNotifLoading', true);

		let response = await axios.get(`${globs.api}notif/notifications`);

		console.log(response.data);

		let data = globs.resp(response);

		if(data.error){

			commit('setNotifications', {
				list 		: data.list,
				error 	: data.error,
				message : data.message,
				notificationsList : []
			});

			commit('setNotifLoading', false);

		}else{

			commit('setNotifications', {
				list 		: data.list,
				error 	: data.list ? false : true,
				message : data.message,
				notificationsList : data.list ? data.notifications : []
			});

			commit('setNotifLoading', false);

		} // End Of Error Check

	}, // End Of Get Notifications

}