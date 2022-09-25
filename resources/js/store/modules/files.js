export const state = {
  image: {
    src: '',
    clipper: '',
    canvas: '',
    file: null,
    url: '',
    pixel: '',
    chosen: false,
    cancel: false,
    rotation: 0
  },
  video: {
    file: null,
    url: ''
  },

  checks: {
    isSet: false,
    done: true
  },

  file: false,
  text: ''
}

export const getters = {
  image: state => state.image,
  video: state => state.video,
  checks: state => state.checks,
  file: state => state.file,
  Text: state => state.text
}

export const mutations = {
  SET_VIDEO: (state, video) => (state.video.file = video),

  SET_VIDEO_URL: (state, url) => (state.video.url = url),
  setText: (state, text) => (state.text = text),
  isFile: function (state, file) {
    state.file = file
  },

  chosen: function (state, chosen) {
    state.image.chosen = chosen
  },

  cancel: function (state, cancel) {
    state.image.cancel = cancel
  },

  done: function (state, done) {
    state.checks.done = done
  },

  isSet: function (state, isSet) {
    state.checks.isSet = isSet
  },

  clipper: function (state, clipper) {
    state.image.clipper = clipper

    // Set Video Files To Null
    state.video.url = ''
    state.video.file = null

    state.checks.done = false
  },

  setRotation: function (state, rotation) {
    state.image.rotation = rotation
  },

  setImage: function (state, args) {
    // Clean Videos

    state.image.canvas = args.canvas

    state.image.canvas.toBlob(function (blob) {
      state.image.file = blob

      state.image.url = URL.createObjectURL(blob)
    })

    state.image.pixel = `${state.image.canvas.width} x ${
      state.image.canvas.height
    }`
  }
}

export const actions = {
  crop: function ({ state, commit }) {
    if (state.image.src != '' && state.image.clipper != '') {
      commit('setImage', {
        canvas: state.image.clipper.clip()
      })

      commit('done', true)
    }
  },
  isSet: function ({ commit }, set) {
    commit('isSet', set)
  },

  chosen: function ({ commit, dispatch, state }, chosen) {
    commit('chosen', chosen)

    if (state.video.file) {
      dispatch('removeVideo')
    }
  },

  cancel: function ({ state, commit, dispatch }) {
    state.image.src = ''
    state.image.clipper = ''
    state.image.rotation = 0
    state.image.canvas = ''
    state.image.pixel = ''
    state.image.file = null
    state.image.url = ''
    state.image.chosen = false
    state.checks.done = true
    state.checks.isSet = false

    state.file = false
  },
  removeVideo ({ commit }) {
    commit('SET_VIDEO_URL', '')
    commit('SET_VIDEO', null)
  },
  removeAll ({ commit, dispatch }) {
    dispatch('cancel')
    dispatch('removeVideo')
  },
  getVideo ({ commit, state, dispatch }, event) {
    if (event.target.files.length === 0) return
    else {
      console.log(event.target.files)

      if (state.video.file) {
        dispatch('removeVideo')
      }

      commit('SET_VIDEO', event.target.files[0])

      commit('SET_VIDEO_URL', URL.createObjectURL(event.target.files[0]))

      commit('isFile', true)
    }
  }
}
