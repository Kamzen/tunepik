<template>
  
  <div class="wrapper">

    <table class="app-full-user-info-table">

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

            <!-- <center> -->

              <span class="app-max-text">
                  
                  {{ user.getActivity().followers }}

                </span>
                
                <div class="space-small"></div>

                <span class="app-bolder-text">
                  Followers
                </span>

            <!--</center> -->

          </router-link>

        </td>

      </tr>

    </table>

  </div>

</template>

<script type="text/javascript">

  export default {

    name  : "UserFollowsBuilder",
    props : ['user']
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