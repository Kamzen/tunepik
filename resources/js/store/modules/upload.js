import axios from 'axios'

// const snackbar = store.mutations['tunepik/SNACK_BAR']

export const state = {

	upload 		: {

		loading 	 : false,
		percentage : 0,
		error 		 : false,
		message    : 'File Not Chosen',
		data 			 : null,

	},

}

export const getters = {

	upload 		: state => state.upload,

}

export const mutations = {

	setLoading  	: (state, loading) 		=> state.upload.loading    = loading,
	setPercentage : (state, percentage)  => state.upload.percentage = percentage,

	setData       : (state, data)				=> {

		state.upload.error 		= data.error;
		state.upload.message 	= data.message;
		state.upload.data 		= data.res

	},

}

export const actions = {

	userUpload  : function({ dispatch, state, commit }, args, callback = null){

		commit('setLoading', true);

		let form = new FormData();

		form.append('text', args.text);
		form.append('media', args.media == undefined ? '' : args.media);
		form.append('app_name', 'Tunepik Web')

		axios.post(`${args.url}`, form, {

			headers : {
				'Content-Type'  : 'multipart/form-data'
			},
			onUploadProgress : function(progressEvent){

				dispatch('uploadProgressEvent', progressEvent)

			}/*.bind(this)*/

		}).then(function({ data }){

				commit('setData', {

					error : data.error,
					message : data.message,
					res : data.error ? null : data

				})

			// snackbar({ isOpen : true, message : data.message, theme : data.error ? 'danger' : 'info' })

			commit('setLoading', false);

		}).catch(function(e){

			commit('setData', {

					error : true,
					message : e.message,
					res : []

				})
			commit('setLoading', false);

		});


	},
	uploadProgressEvent : function({ state, commit}, progressEvent){

		commit('setPercentage', parseInt(Math.round((progressEvent.loaded / progressEvent.total)) * 100));

	}

}