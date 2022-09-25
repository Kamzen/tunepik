<template>
       
  <div class="wrapper-view">

    <!-- User Profile Nav Bar! -->

    <div class="navbar fixed-top">
      
      <UserNavBuilder :user="user"></UserNavBuilder>

    </div>

    <!-- Cover Photo! -->
    <div class="user-wrap-cover">
      
    </div>
    <div class="space-large"></div>
    <div class="space-large"></div>

    <!-- Show Info About User -->

    <div class="user-info-wrapper">

       <UserInfoBuilder :user="user">
         
         <div></div>

       </UserInfoBuilder>

       <div class="space-small"></div>

       <center>
         <UserStatsBuilder :user="user"></UserStatsBuilder>
       </center>

    </div>

    <!-- Will Have To Create A Component For This -->
    <div class="grey-matter app-shared-post mt-4 pt-3 pb-3" v-if="user.getActivity().blocked">
      <center>
        <span v-if="user.getActivity().youBlock" class="app-small-text">You Have Blocked</span> 
        <span v-else class="app-small-text">You Have Been Blocked By </span>
        <span class="app-max-text">
          @{{ user.getBasic().handle }}
        </span>
      </center>
    </div>
    <UserExtendedView :user="user" v-else></UserExtendedView>

    <div class="space-large"></div>
    <div class="space-large"></div>
    <div class="space-large"></div>
  
  </div>

</template>

<script>

   import UserInfoBuilder from '../../builders/profileBuilders/UserInfoBuilder'
   import UserExtendedView from '../../builders/profileBuilders/UserExtendedView'
   // import UserFollowsBuilder from '../../builders/profileBuilders/UserFollowsBuilder'
   import UserStatsBuilder from '../../builders/profileBuilders/UserStatsBuilder'
   import UserNavBuilder from '../../builders/profileBuilders/UserNavBuilder'

    export default {
        name: "DesktopProfileView",
        scrollToTop : false,
        components : {

          // UserFollowsBuilder,
          UserExtendedView,
          UserStatsBuilder,
          UserInfoBuilder,
          UserNavBuilder

        },
        props : ['user']
        
    };
</script>

<style scoped>


  .user-wrap-cover{
   /* height : 110px;*/
  }

  .scroll-wrapper{

    width : 90%;
    position : relative;
    top : -100px;
    left : 45px;

  }

  .navbar{

    padding : 0;
    box-shadow: 0 .5px 1px 0 rgba(211, 211, 211, .4);
    height: 50px;

  }

</style>