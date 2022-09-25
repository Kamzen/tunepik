<template>

	<div class="profile-user-info darkmode-wrapper">

    <div class="media">

      <div class="user-profile-image mr-1">
         <Picture :width="60" :height="60" :user="user"></Picture>
      </div>
      <div class="media-body ml-3 ">
        <table >
          <tr>
            <td>
              <router-link :to="{ name : 'profile', params : {username : user.getBasic().handle } }">
                <span class="user-profile-handle app-max-text">
                  {{ user.getBasic().name }}
                </span>
              </router-link>
              <br />
              <span v-if="!user.getActivity().blocked">

                <i class="app-fa fas fa-calendar-alt icon-grey"></i>
                <span class="app-grey-text"> Joined On {{ user.getBasic().date }} </span>
                <br />
                <span v-if="user.getInfo().location">
                  <span class="app-fa fas fa-map-pin icon-grey"></span>
                  <span class="app-grey-text"> {{ user.getInfo().location }}</span>
                </span>
                <span v-else>
                  <router-link :to="{ name : 'edit.account', params : { username : user.getBasic().handle } }">
                    <span class="app-fa fas fa-map-pin icon-grey"></span>
                    <span class="app-post-text edit-text">add location</span>
                  </router-link>
                </span>

              </span>
              
            </td>
            <td>
              <slot />
            </td>
          </tr>
        </table>

        <div class="space-small"></div>
        <div class="space-small"></div>

        <UserFollowsBuilder :user="user" v-if="screen"></UserFollowsBuilder>

      </div>
      <div class="app-user-more align-self-start pr-1" v-if="!user.getActivity().me">
        <a @click="show = !show">
          <Icon :icon="'arrowdown'" :height="19" :width="19"></Icon>
        </a>
        <div class="overlay-wrap" v-show="show">
          <div class="main-wrap card" v-show="show" :class="[ show ? 'fade-in' : 'fade-out']">
            <div class="card-header media">
              <Picture :user="user" :height="40" :width="40"></Picture>
              <div class="media-body align-self-center pl-3">
                <span class="app-max-text">More</span>
                <span class="app-grey-text-lg block-text">(@{{user.getBasic().handle}})</span>
              </div>
              <div class="media-right align-self-center">
                <a @click="show = !show">
                  <i class="fa fa-times app-fa"></i>
                </a>
              </div>
            </div>
            <div class="card-body list-group">
              <ProfileOptions :user="user"></ProfileOptions>
            </div>
          </div>
        </div>
      </div>
      <!-- End of Media -->
    </div>

    <center>
      <div class="user-bio" style="width: 90%;">
        <span class="app-post-text" v-if="user.getInfo().bio && !user.getActivity().blocked">
          <!-- {{ user.getInfo().bio }} -->
          <text-body-builder :text="user.getInfo().bio"></text-body-builder>
        </span>
        <div class="" v-else>
          <span class="app-post-text" v-if="user.getActivity().me">
            <!-- Add Edit Account Router View Here -->
             <!-- Write Edit with an edit pencil -->
             <router-link :to="{ name : 'edit.account', params : { username : user.getBasic().handle } }">
               <span class="app-post-text edit-text">add bio</span>
             </router-link>
          </span>
          <span class="app-post-text" v-else>
            Hey, I'm new to tunepik!
          </span>
        </div>

      </div>
    </center>

  </div>
	
</template>

<script>

  import globs from '../../../tunepik/attack.js'
  import UserFollowsBuilder from './UserFollowsBuilder'
  import ProfileOptions from '../popupBuilders/ProfileOptions'
  import TextBodyBuilder from '../postBuilders/TextBodyBuilder'
  
  export default {

  	name  : 'UserInfoBuilder',
    data : () => ({
      screen : globs.app.isMobile,
      show : false,
    }),
    components :{
      UserFollowsBuilder,
      TextBodyBuilder,
      ProfileOptions
    },
  	props : ['user']

  };
	

</script>

<style scoped>

  @media only screen and (min-width : 700px){

    table{

      width : 100%;

    }

  }

  br{
    margin : 0;
    padding: 0;
  }

  .icon-grey{
    color : rgba(211, 211, 211, 1);
  }

  .edit-text{
    color: blue;
    border-bottom: .04em solid blue;
  }
	
</style>