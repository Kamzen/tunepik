<template>

	    <div>

	    	<div class="" v-if="loading">

         <PostSkeleton></PostSkeleton>

       </div>
       <div class="" v-else>

          <div v-if="list" class="posts" id="xxx">

            <div class="list-group" v-for="(PostModel, index) in posts" :key="index">
              
              <post :post="PostModel" :comments="true" class="list-group-item no-border" ></post>

            </div>

            <div class="space-medium"></div>

            <div class="app-load" ref="appLoader">

              <SinglePostSkeleton></SinglePostSkeleton>

              <center class="heartbroken" name="loader">
                <div class="app-loader" style="background-color:transparent"></div>
              </center>

              <!-- <center>
                <v-button :type="'primary'" @click.native="makeInfiniteRequest()">more</v-button>
              </center> -->

            </div>
            <div class="space-large"></div>
            <div class="space-large"></div>
            <div class="space-large"></div>


         </div>
         <div v-else>

           <div class="space-large"></div>
           <div class="app-deleted-post grey-matter pt-3 pb-3">

            <div class="media">
              
              <div class="media-left align-self-center pl-2">
                <i class="app-e-fa fa fa-folder-open" :style="{ color : theme.icons.color }"></i>
              </div>
              <div class="media-body align-self-center pl-3">
                
                  <span class="app-small-text">
                    {{ message }}
                  </span>

              </div>

            </div>
              

           </div>

         </div>

       </div>

	    </div>

	    <!-- <div v-else>

	    	GRIDD

	    </div> -->

</template>

<script>

   import Post from '../Post'
   import PostSkeleton from '../skeletonBuilders/PostSkeleton'
   import SinglePostSkeleton from '../skeletonBuilders/SinglePostSkeleton'
   import { mapActions, mapGetters } from 'vuex'

		export default {

			name    : "PostsBundler",
      data    : () => ({
        url   : '',
        loaded : true,
        loaderVisible : false,
      }),
			components : {

				Post,
        PostSkeleton,
        SinglePostSkeleton

			},
			props   : ['posts', 'list', 'type', 'loading','message'],
      methods : {

        ...mapActions('tunepik', ['scroller']),
        ...mapActions('posts', ['getResults', 'getPosts']),
        ...mapActions('profile', ['getUserPosts', 'getLikedPosts']),
        makeInfiniteRequest : function(){

          let url = ''

          switch (this.$router.currentRoute.name) {

            case  'home'  :

              url = `/api/posts/feed/`

              this.getPosts({url : url, lastId : this.lastId})

              break;

            case 'profile' :

              url = this.profile.model ? `/api/posts/user/${this.profile.model.getBasic().id}/` : ''

              this.getUserPosts({url : url, lastId : this.lastId})

              break;

            case 'liked' :

              url = this.profile.model ? `/api/posts/liked/${this.profile.model.getBasic().id}/`: ''

              this.getLikedPosts({url : url, lastId : this.lastId})
              
              break;

            case 'results' :

              url = `/api/posts/search/feed/${this.$router.currentRoute.params.term}/?type=posts&`

              this.getResults({url : url, lastId : this.lastId})

              break;

          }

        }

      },
      computed : {

			  ...mapGetters('profile', ['profile']),
        ...mapGetters('tunepik', ['theme']),
        color : function(){
          return this.theme.type === 'theme-dark' || this.theme.type === 'theme-dim' ? this.theme.colors.lightgrey : this.theme.colors.darkgrey
        },
        lastId : function(){
			    return this.posts.length > 4 ? this.posts[this.posts.length - 1].getPost().id : 0
        },
        args : async function(){

          return  {

            callback : (isVisible) => {

                if(isVisible){

                  if(this.infite){

                    this.loaderVisible = true
                    

                    this.makeInfiniteRequest()

                    this.infite = false

                  }

                }else{

                  this.loaderVisible = false
                  this.infite = true

                }


              },
            element : await this.tag,
            inView  : true

          }

        },
        tag : async function(){

          const tags = await this.$el.getElementsByTagName('center')

          return tags.length > 0 ? tags[tags.length - 1] : 0
        }

        /*data : function(){

          return {

            options  : {
              threshold : 1.0,
              rootMargin : '0px'
            },
            callback : (entries, observer) => {

              entries.forEach((entry) => {

                console.log(entry)

                if(entry.intersectionRatio > 0.10){

                  // Call
                  console.log('inview!')
                  console.log(observer)
                  alert('Im SEEN')

                }else{
                  console.log('NAHHH')
                }

              })

            },
            target   : this.$el.getElementsByTagName('center')[0]

          }

        }
*/
      },/*
      mounted : function(){
      },*/
      watch : {

        posts : async function(posts){

          if(posts)  this.scroller(await this.args)

        },

      }

		};

</script>

<style scoped>

    @media only screen and (min-width: 700px){
      .list-group-item,
      .list-group{
        background-color: transparent;
      }
    }

   .list-group-item{
    /*border : 0;
    border-bottom: .09em solid rgba(211, 211, 211, .5);*/
    padding-left: 0;
    padding-right: 0;
   }

   .app-e-fa{
    width: 40px;
    height: 40px;
   }

   .app-loader{
    border: 5px solid transparent;
    border-top: 5px solid transparent;
   }

</style>
