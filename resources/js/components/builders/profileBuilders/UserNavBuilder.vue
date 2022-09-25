<template>
  
  <div class="wrapper">

    <div class="app-user-info-nav darkmode-wrapper">

      <table class="app-user-info-nav-table">

        <tr class="app-user-info-nav-tr">

          <td class="app-tab app-user-info-nav-tab back-tab pt-2 pl-1">
            <center>
              <Picture :height="36" :width="36" :user="user"></Picture>
            </center>
          </td>

          <td class="app-tab app-user-info-nav-tab user-name-tab pl-2">
            <router-link :to="{ name : 'profile', params : { username : user.getBasic().handle } }" class="name-link">
              <user-name :limit="12" :user="user"></user-name>
            </router-link>

          </td>

          <template v-if="user.getActivity().me">
            <td class="app-tab app-user-info-nav-tab first-buttons-tab pl-2">
              <router-link  :to="{ name : 'edit.account', params : { username : user.getBasic().handle } }">
                <v-button :class="[screen ? '' : 'btn-sm']" :type="'primary'">Edit Profile</v-button>
              </router-link>
              
            </td>
            <td class="app-tab app-user-info-nav-tab second-buttons-tab pr-3">

              <!-- Show Edit Profile Button -->
              <center>
                <router-link :to="{ name : 'edit', params : { username : user.getBasic().handle } }">
                 <i class="fa fa-cogs app-fa"></i>
                </router-link>
              </center>

            </td>

          </template>
          <template v-else>


            <td class="first-buttons-tab app-tab app-user-info-nav-tab" style="width:15%;">

              <!-- Show Follow Button -->

              <FollowButton :user="user" :classes="''"></FollowButton>

            </td>
            
            <td class="second-buttons-tab app-tab app-user-info-nav-tab pl-3 pr-2" style="width:10%;" >

              <!-- Show Message Button -->
              <router-link :to="{ name : 'messages', params : { username : user.getBasic().handle } }" v-if="!user.getActivity().blocked">
                <a @click="MESSAGE_USER({ error : false, message : 'User Found', user : message })">
                 <i class="fa fa-envelope-open app-fa"></i>
               </a>
              </router-link>

            </td>

          </template>

        </tr>

      </table>

    </div>


  </div>

</template>

<script type="text/javascript">

 import FollowButton from '../userBuilders/FollowButton'
 import { mapGetters, mapMutations } from 'vuex'
 import globs from '../../../tunepik/attack.js'

  export default {

    name : "UserNavBuilder",
    data : () => ({
      trim : globs.trim,
      screen : globs.app.isMobile
    }),
    components : {
      FollowButton
    },
    props : ['user'],
    methods : {
      ...mapMutations('messages', ['MESSAGE_USER']),
      back : function(){
        window.history.back();
      }
    },
    computed : {
      ...mapGetters('tunepik', ['theme'])
    }

  };
  

</script>

<style scoped>

  
  @media only screen and (min-width : 700px){

    .card-header{

      padding : 0;
    }

    .app-user-info-nav,
    .app-user-info-nav-table,
    .app-user-info-nav-tab{
      padding : 0;
    }

    .first-buttons-tab,
    .second-buttons-tab{

      width: 20%;

    }

    .user-name-tab{

      width : 50%;

    }

  }

  @media only screen and (max-width: 699px){

    .app-user-info-nav,
    .app-user-info-nav-table,
    .app-user-info-nav-tab{
      padding : 0;
    }


    table,
    .wrapper{
      width: 100%;
    }

    .app-user-info-nav{
      height: 45px;
    }


  }
  
</style>