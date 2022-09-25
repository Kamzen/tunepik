<template>

	<div class="button-wrapper">
		
		<!-- Follow Button -->

    <template v-if="User.getActivity().me"></template>
    <template v-else>
      
      <!-- If User Is Following! -->
      <!-- <template v-if="model.getActivity().following">



      </template>
      <template v-else>
        
      </template> -->


      <!-- Confirm Unfollow Pop Up Box -->

      <PopUpWindow :headerText="headerText" :show="show" v-if="User.getActivity().following">
        
        <div class="list-group">
          
          <div class="list-group-item">
            <center>
              <span class="app-grey-text-lg">Are You Sure You Want To Unfollow 
                <span class="app-bolder-text">@{{ User.getBasic().handle }}</span>?
                <br /> He/She Will Know You Unfollowed Them
              </span>
            </center>
          </div>
          <div class="list-group-item">
            
            <button v-on:click="followUser(user)" class="btn btn-info mobile-share-control-btn yes">Unfollow @{{ User.getBasic().handle }}</button>
            <button v-on:click="toggleConfirm()" class="btn btn-danger mobile-share-control-btn no">Cancel</button>

          </div>

        </div>

      </PopUpWindow>



      <!-- Follow Buttons -->

      <button v-on:click="toggleConfirm()" class="btn btn-info" v-bind:class="[classes]" v-if="user.getActivity().following">

        <div class="spinner-grow text-success spinner-grow-sm" role="status" aria-hidden="true" v-if="User.loading"></div>
        
        <span class="" v-if="!User.loading">
          {{ Message }}
        </span>

      </button>

      <button v-on:click="followUser(user)" class="btn btn-default" v-bind:class="[classes]" v-else>

        <div class="spinner-grow text-success spinner-grow-sm" role="status" aria-hidden="true" v-if="User.loading"></div>

        <span class="" v-if="!User.loading">
          {{ Message }}
        </span>

      </button>

    </template>

	</div>
       
</template>

<script>

  import globs from '../../../tunepik/attack.js'
  import {mapGetters, mapActions} from 'vuex'
  import PopUpWindow from '../popupBuilders/PopUpWindow'

    export default {

        name    : "FollowButton",
        components : {

          PopUpWindow

        },
        data    : () => {

          return {

            screen      : globs.app.isMobile,
            model       : {},
            classActive : '',
            message     : '',
            show        : false,

          }

        },
        props   : ['user', 'classes'],

        methods : {

          ...mapActions("follow", ['setFollowState', 'followUser']),
          toggleConfirm : function(){

             this.show = this.show == true ? false : true;

          },

        },
        computed : {

          ...mapGetters("follow", ["follow"]),
          headerText : function(){

            return `Unfollow @${this.user.getBasic().handle}`;

          },
          btnStyle : function(){

            this.classActive = this.class;

            return this.classActive;

          },
          User : function(){

            this.user.loading = false;
            this.model = this.user;

            return this.model;

          },
          Message : function(){

            this.message = this.user.getActivity().following ? 'Following' : 'Follow';

            return this.message;

          }

        }

    };
</script>

<style scoped>

  .button-wrapper{
    margin : 0;
    padding : 0;
    width: 100%;
  }

  .list-group-item{
    border : 0;
  }

</style>
