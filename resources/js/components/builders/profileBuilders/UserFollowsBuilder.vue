<template>
  
  <div class="wrapper">

    <div class="" v-if="screen">
      
      <router-link @click.native="isBlocked()" :to="{ name : 'follows', params : { type : 'following' } }" class="following-btn">
                <span class="app-max-text">
                  
                  {{ user.getActivity().follows }}

                </span>

                <span class="app-small-text">
                  Following
                </span>
        </router-link>

        <router-link @click.native="isBlocked()" :to="{ name : 'follows', params : { username : user.getBasic().handle, type : 'followers' } }" class="followers-btn">
            <span class="pl-3">

                <span class="app-max-text">
                  
                  {{ user.getActivity().followers }}

                </span>
                <span class="app-small-text">
                  Followers
                </span>

            </span>
          </router-link>

    </div>

    <table class="app-full-user-info-table" v-else>

      <tr class="app-follows-tr">

        <td class="app-tab app-full-info-tab following-tab">

            <router-link :to="{ name : 'follows', params : { type : 'following' } }" class="following-btn">

              <!-- <center> -->

                <span class="app-max-text">
                  
                  {{ user.getActivity().follows }}

                </span>

                <div class="space-small"></div>

                <span class="app-bolder-text">
                  Following
                </span>

              <!-- </center> -->

            </router-link>

        </td>

        <td class="app-tab app-full-info-tab followers-tab">

          <router-link :to="{ name : 'follows', params : { username : user.getBasic().handle, type : 'followers' } }" class="followers-btn">
              <span class="app-max-text">
                  
                  {{ user.getActivity().followers }}

                </span>
                
                <div class="space-small"></div>

                <span class="app-bolder-text">
                  Followers
                </span>
          </router-link>

        </td>

      </tr>

    </table>

  </div>

</template>

<script type="text/javascript">

 import globs from '../../../tunepik/attack.js'
 import { mapMutations } from 'vuex'

  export default {

    name  : "UserFollowsBuilder",
    data  : () => ({

      screen : globs.app.isMobile,
      snackBar : {
        isOpen : true,
        message : 'Cannot View Following/Followers, You Are Blocked!',
        theme : 'primary'
      }

    }) ,
    props : ['user'],
    methods : {
      ...mapMutations('tunepik', ['SNACK_BAR']),
      isBlocked : function(){
        if(user.getActivity().blocked) this.SNACK_BAR(this.snackBar)
      }
    }
  };
  

</script>

<style scoped>

  @media only screen and (min-width: 700px){

    .app-full-user-info-table{
      width: 100%;
    }

  }

  @media only screen and (max-width: 700px){

    .app-full-user-info-table{
      width: 80%;
    }


  }
  
</style>