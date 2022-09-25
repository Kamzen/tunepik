<template>

  <div class="media pl-1 pr-1 mt-2 mb-2">

    <!-- User Image -->
    <Picture class="pl-1" :height="pictureSize" :width="pictureSize" :user="post" ></Picture>

    <div class="media-body ml-3 align-self-center">
      
      <router-link v-bind:to="{ name : 'profile', params :{ username : post.getBasic().handle } }">
        <a @click="SET_PROFILE(post)">
          <user-name :user="post"></user-name>
        </a>
      </router-link>

    </div>

    <!-- User Options Button -->
    <div class="post-header-icon-wrapper "> <!-- pr-2 align-self-center b-media -->
      
      <div class="options-round">
        
        <a class="post-header-icon" @click="show = !show">
          <Icon :icon="'arrowdown'" :height="20" :width="20"></Icon>
        </a>

      </div>

      <!-- Insert PopUp Window -->
      <div class="overlay-wrap" v-show="show">
        
        <div class="main-wrap card" v-show="show" :class="[ show ? 'fade-in' : 'fade-out']">
          
          <div class="media card-header">
            
            <div class="media-left align-self-center">
              
              <Picture :height="30" :width="30" :user="post"></Picture>

            </div>

            <div class="media-body pl-3 align-self-center">
              
              <span class="app-max-text">
                Options <!-- {{ headerText }} -->
              </span>
              <span class="block-text app-grey-text-lg">
                (@{{ post.getBasic().handle }})
              </span>

            </div>
            <div class="align-self-center media-right">
              
              <a @click="show = !show">
                <i class="fa fa-times app-fa"></i>
              </a>

            </div>

          </div>
          <div class="card-body">
            
            <PostOptions :post="post"></PostOptions>

          </div>

        </div>

      </div>

    </div>

  </div>
       
</template>

<script>

  import globs from '../../../tunepik/attack.js'
  import PostOptions from '../popupBuilders/PostOptions'
  import { mapMutations } from 'vuex'

    export default {

        name        : "HeaderBodyBuilder",
        components  : {

          PostOptions

        },
        data        : () => ({

          screen : globs.app.isMobile,
          header : '',
          show   : false

        }), 
        props   : ['post'],
        methods  : {

          ...mapMutations('profile', ['SET_PROFILE']),

        },
        computed : {

          headerText : function(){

              this.header = `@${this.post.getBasic().handle} Post Options`;
              return this.header;

          },
          pictureSize : function(){
            return screen ? 40 : 55
          }

        }

    };
</script>

<style scoped>

  .options-round{

    border-radius: 15px;
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 7px;
    padding-right: 7px;

  }

</style>
