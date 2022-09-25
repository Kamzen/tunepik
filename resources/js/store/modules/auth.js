import axios from 'axios'
import Cookies from 'js-cookie'
import globs from '../../tunepik/attack.js'
import * as types from '../mutation-types'


//apunkagames.com/net

// state
export const state = {
  user: null,
  loading : false,
  model : null,
  token: Cookies.get('token'),

  update : {

    loading : false,
    error   : false,
    message : '',
    data    : null,

  },
  register : {
    username : '',
    email    : '',
    password : ''
  }


}

// getters
export const getters = {
  user      : state => state.user,
  loading   : state => state.loading,
  model     : state => state.model,
  token     : state => state.token,
  check     : state => state.user !== null,
  update    : state => state.update,
  register  : state => state.register,
}

// mutations
export const mutations = {

  password      : (state, password) => state.register.password = password,

  email         : (state, email)    => state.register.email = email,

  username      : (state, username) => state.register.username = username,

  setModel      : (state, data)     => state.model = new globs.model.user(data),

  setLoading    : (state, loading)  => state.loading = loading,

  setULoading   : (state, loading)  => state.update.loading = loading,

  updateUser    : (state, data)     => {

    state.update.error = data.error;

    state.update.message = data.message;

  },
 
  [types.SAVE_TOKEN] (state, { token, remember }) {
    state.token = token
    Cookies.set('token', token, { expires: remember ? 365 : null })
  },

  [types.FETCH_USER_SUCCESS] (state, { user }) {
    state.user = user
  },

  [types.FETCH_USER_FAILURE] (state) {
    state.token = null
    Cookies.remove('token')
  },

  [types.LOGOUT] (state) {
    state.user = null
    state.token = null

    Cookies.remove('token')
  },

  [types.UPDATE_USER] (state, { user }) {
    state.user = user
  }
}

// actions
export const actions = {
  saveToken ({ commit, dispatch }, payload) {
    commit(types.SAVE_TOKEN, payload)
  },

  async fetchUser ({ commit }) {

    commit('setLoading', true);

    try {
      const { data } = await axios.get('/api/user')

      commit(types.FETCH_USER_SUCCESS, { user: data })

      commit('setModel', data.model);
      commit('setLoading', false);

    } catch (e) {
      commit(types.FETCH_USER_FAILURE);
      commit('setLoading', false);
    }
  },

  updateUser ({ commit }, payload) {
    commit(types.UPDATE_USER, payload)
  },

  async logout ({ commit }) {
    try {
      await axios.post('/api/logout')
    } catch (e) { }

    commit(types.LOGOUT)
  },

  async fetchOauthUrl (ctx, { provider }) {
    const { data } = await axios.post(`/api/oauth/${provider}`)

    return data.url
  },

  updateUserInfo : async function({ state, commit }, formData, model){

    commit('setULoading', true);

    let form = new FormData(formData);

     const { data } = await axios.post(`/api/user/update`, form);

       if(data.error){

          commit('updateUser', {

            error : true,
            message : data.message

          });
          commit('setULoading', false);

       }else{

          const { data } = await axios.get('/api/user');

          commit(types.FETCH_USER_SUCCESS, { user: data })

          commit('setModel', data.model);
          commit('setLoading', false);

          commit('updateUser', {

            error   : false,
            message : data.message

          });

          commit('setULoading', false);

       }

  }


}
