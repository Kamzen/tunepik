import axios from "axios";
import globs from '../../tunepik/attack.js'

export const state = {

  allPosts : [],
  list     : false,
  error    : false,
  message  : 'No Feed To Show',
  loading  : true,

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

  }

}

export const getters = {

  Posts   : state => state.allPosts,
  list    : state => state.list,
  message : state => state.message,
  loading : state => state.loading,
  atComments   : state => state.atComments,
  postComments : state => state.postComments

}

export const mutations = {

  setPosts : (state, data) => {

    state.allPosts = data.posts;

    state.list     = data.list;

    state.message  = data.message;

    state.error    = data.error;

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


  }

}

export const actions = {


  /*
   Get Comments
  */

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

    }

  },

  /**
   * Get All Posts For Main Feed Page
   */

  async getPosts({ commit }){

    /*
        Set Loading Status To True!
     */
      commit('setLoading', true);

      const response = await axios.get(`${globs.api}posts/feed`);

      let posts = globs.resp(response);

      commit('setLoading', false);

        // Check For Errors
        if(posts.error){

          commit('setPosts', {posts : [], list : false, message : posts.message, error : false});

        }else{

          if(posts.list){

            let postsList = [];

              posts.posts.forEach(function(postData, index){

                  postsList.push(new globs.model.post(postData))

              });

              /*
               * Commit The Data To The State
               */
               commit('setPosts', {posts : postsList, list : posts.list, message : posts.message, error : false})

          }

        }

    }

}

