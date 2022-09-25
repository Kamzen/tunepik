import axios from "axios";
import globs from '../../tunepik/attack.js'

export const state = {

  allPosts : [],
  list     : false,
  error    : false,
  message  : 'No Feed To Show',
  loading  : true,

  focusPost : null,

  atComments : {

    postLoading : false,
    message   : '',
    post      : null,
    error     : false

  },

  postComments : {

    commentsLoading : false,
    message         : '',
    comments        : [],
    list            : false,
    error           : false

  },

  explore     : {

    loading   : false,
    error     : false,
    list      : false,
    message   : '',
    posts     : [],

  },

  results  : {

    loading : false,
    error   : false,
    list    : false,
    message : '',
    posts   : []

  }

}

export const getters = {

  Posts   : state => state.allPosts,
  list    : state => state.list,
  message : state => state.message,
  loading : state => state.loading,
  atComments   : state => state.atComments,
  postComments : state => state.postComments,
  explore      : state => state.explore,
  focusPost : state => state.focusPost,
  results   : state => state.results,

}

export const mutations = {

  setPosts : (state, data) => {

    state.list     = data.list;

    state.message  = data.message;

    state.error    = data.error;

    /*state.allPosts = data.posts;*/

    data.posts.forEach((post) => {
      state.allPosts.push(new globs.model.post(post))
    })

  },

  setLoading : (state, loading) => (state.loading = loading),

  setGetSinglePostLoading : (state, loading) => (state.atComments.postLoading = loading),

  setAtComments : (state, data) => {

    state.atComments.message = data.message;

    state.atComments.error  = data.error;

    state.atComments.post = data.post;

  },

  setGetCommentsLoading : (state, loading) => (state.postComments.commentsLoading = loading),

  setPostComments : (state, data) => {


     state.postComments.message = data.message;

     state.postComments.list    = data.list;

     state.postComments.comments = data.comments;

     state.postComments.error = data.error;


  },

  setXLoading     : (state, loading) => state.explore.loading = loading,
  setExplore      : (state, data) => {

    state.explore.error    = data.error;
    state.explore.list     = data.list;
    state.explore.message  = data.message;

    data.posts.forEach(function(postData, index){

      state.explore.posts.push(new globs.model.post(postData));

    });

  },
  MAIN_POST : (state, post) => {

    state.focusPost = post

  },

  SET_RLOADING : (state, loading) => {
    state.results.loading = loading
  },
  SET_RESULTS : (state, data) => {

    state.results.error = data.error
    state.results.list  = data.list
    state.results.message = data.message

    data.posts.forEach((post) => {

      state.results.posts.push(new globs.model.post(post))

    })

  }


}

export const actions = {

  getPostComments : async function({ commit }, postId){

    commit('setGetCommentsLoading', true);

    const response = await axios.get(`${globs.api}comments/${postId}`);

    let data = globs.resp(response);

     if(data.error){

       commit('setPostComments',{

         message  : data.message,
         list     : data.list,
         error    : data.error,
         comments : []

       });

       commit('setGetCommentsLoading', false);

     }else{

       if(data.list){

          let commentsList = [];

          data.comments.forEach(function(commentData, index){

            commentsList.push(new globs.model.comment(commentData));

          });

          commit('setPostComments',{

             message  : data.message,
             list     : data.list,
             error    : data.error,
             comments : commentsList

           });

          commit('setGetCommentsLoading', false);


       }else{

          commit('setPostComments',{

           message  : data.message,
           list     : data.list,
           error    : data.error,
           comments : []

         });

          commit('setGetCommentsLoading', false);

       }

     }

  },

  /*
   Set And Get Post For Checking Comments
  */

  setSinglePost : function({ commit }, postModel){

    commit('setAtComments', {

          error   : false,
          message : 'Post Available',
          post    : postModel

       });

  },

  getSinglePost : async function({ commit }, id){

    commit('setGetSinglePostLoading', true);

    const response = await axios.get(`${globs.api}posts/single/${id}`);

    let post = globs.resp(response);

    commit('setGetSinglePostLoading', false);

    if(post.error){

       commit('setAtComments', {

          error   : post.error,
          message : post.message,
          post    : null

       });

       commit('setGetSinglePostLoading', false);

    }else{

      commit('setAtComments', {

          error   : post.error,
          message : post.message,
          post    : new globs.model.post(post.posts[0])

       });

      commit('setGetSinglePostLoading', false);
      commit('MAIN_POST', new globs.model.post(post.posts[0]))

    }

  },

  /**
   * Get All Posts For Main Feed Page
   */

  getPosts({ commit }, form){

    /*
        Set Loading Status To True!
     */
      if(!form.lastId) commit('setLoading', true);

     /* const response = await */
     axios.get(form.lastId ? `${form.url}?last_id=${form.lastId}` : form.url).then(response => {

       let posts = response.data

       // Check For Errors
        if(posts.error){

          commit('setPosts', {posts : [], list : false, message : posts.message, error : false});

        }else{

          if(posts.list){


              /*
               * Commit The Data To The State
               */
               commit('setPosts', {posts : posts.posts, list : posts.list, message : posts.message, error : false})

          }

        }

        commit('setLoading', false);

     })

       

    },

    getExplorePosts   : async function({ commit }, url){

      commit('setXLoading', true);

      let response = await axios.get(url);

      let data = globs.resp(response);

        if(data.error){

          commit('setExplore', {

            error     : true,
            list      : false,
            message   : data.message,
            posts     : []

          });

          commit('setXLoading', false);

        }else{

          commit('setExplore', {

            error     : data.list ? false : true,
            list      : data.list,
            message   : data.message,
            posts     : data.list ? data.posts : []

          });

          commit('setXLoading', false);

        }

    },
    getResults : async function({ state, commit }, form){

      if(!form.lastId) commit('SET_RLOADING', true)

      const { data } = await axios.get(form.lastId ? `${form.url}?last_id=${form.lastId}` : form.url)

       commit('SET_RESULTS', {
         error  : data.list ? data.error : true,
         list   : data.list,
         message : data.message,
         posts  : data.list ? data.posts : []
       })
       commit('SET_RLOADING', false)

    }

}

