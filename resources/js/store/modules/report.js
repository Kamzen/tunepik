

export const state = {

  reporter : {
    reportObj : null,
    type : ''
  },

}

export const getters = {

  reporter : state => state.reporter,

}

export const mutations = {

  SET_REPORT : (state, args) => {

  	console.log(args)
    state.reporter.reportObj = args.obj
    state.reporter.type = args.type

  }

}

export const actions = {}
