<template>

	<div class="profile-user-info darkmode-wrapper">

        <div class="media">

          <div class="user-profile-image mr-1">

             <img width="60" height="60" class="rounded-circle media-object profile-user-profile-img" :src="'' + user.getImgs().profile" />
          
          </div>

          <div class="media-body ml-3">

            <table >
              <tr>
                <td>

                  <router-link :to="{ name : 'profile', params : {username : user.getBasic().handle } }">
              
                    <span class="user-profile-handle app-max-text">
                      {{ user.getBasic().name }}
                    </span>

                  </router-link>
                  <br />
                  <i class="app-fa fas fa-calendar-alt"></i>
                  <span class="app-grey-text"> Joined On {{ user.getBasic().date }} </span>
                  <br />
                  <span v-if="user.getInfo().location != null">
                    <span class="app-fa fas fa-map-pin"></span>
                    <span class="app-grey-text"> {{ user.getInfo().location }}</span>
                  </span>
                  
                </td>
                <td>
                  <slot />
                </td>
              </tr>
            </table>


            <UserFollowsBuilder :user="user" v-if="screen"></UserFollowsBuilder>

          </div>
          <div class="app-user-more" style="padding-right: 2%">

            <a class="app-menu-btn-xs"></a>

          </div>
          <!-- End of Media -->
          
        </div>

        <center>
          <div class="user-bio" style="width: 90%;">
            
            <span class="app-post-text">
              
              {{ user.getInfo().bio }}

            </span>

          </div>
        </center>

      </div>
	
</template>

<script>


  import globs from '../../../tunepik/attack.js'
  import UserFollowsBuilder from './UserFollowsBuilder'
  
  export default {

  	name  : 'UserInfoBuilder',
    data : function(){

      return {

         screen : globs.app.isMobile

      };

    },
    components :{

      UserFollowsBuilder

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

  .app-fa{
    color : rgba(211, 211, 211, 1);
  }
	
</style>