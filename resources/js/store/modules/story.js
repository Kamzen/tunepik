import globs from '../../tunepik/attack.js'
import axios from 'axios'




function findStoryEntry(stateStories, story){

	// To Make The Search, Will Implement Two-way Search Algorithm
	for(let i = 0; i < stateStories.length; i++){

		if(stateStories[i].user.getBasic().id === story.getBasic().id) return { index : i, found : true }

	}

	return { index : null, found : false }

}

export const state = {

	stories : {
		loading : true,
		message : '',
		error   : false,
		stories : []
	},
	view 	: {
		index : 0
	}

}

export const getters = {
	stories : state => state.stories,
	view 		: state => state.view,
}

export const mutations = {

	setLoading : (state, loading) => state.stories.loading = loading,
	setStories : (state, data) => {

		state.stories.message = data.message
		state.stories.error 	= data.error

		if(data.stories.length > 0){

			data.stories.forEach(story => {

				let modelStory = new globs.model.story(story)
				let stateStories = state.stories.stories

				let find = findStoryEntry(stateStories, modelStory)

					if(find.found){

						stateStories[find.index].userStories.push(modelStory)

					}else{

						// Creates A New Entry In State Stories
					  let stateStory = {

							user : new globs.model.user(story.user),
							userStories : []

						}

						stateStory.userStories.push(modelStory)
						// Insert The New Entry
						stateStories.push(stateStory)

					}

			}) 	// End Of For Each Loop

		}

	},
	SET_VIEW_INDEX : (state, args) => state.view.index = args.index

}

export const actions = {

	getStories({ state, commit }, form){

		if(!form.lastId) commit('setLoading', true)

		axios.get(form.lastId ? `${form.url}/?last_id=${form.lastId}` : form.url)
				 .then(({ data }) => {

				 	commit('setStories', { message : data.message, error : data.error, stories : data.stories || [] })

				 	commit('setLoading', false)

				 })
				 .catch( e => {

				 	console.error(e)

				 })

	}

}