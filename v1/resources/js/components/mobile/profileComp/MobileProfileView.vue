<template>
       
  <div class="wrapper-view">

    <!-- User Profile Nav Bar! -->

    <div class="navbar fixed-top navbar-light bg-white">
      
      <UserNavBuilder :user="user"></UserNavBuilder>

    </div>

    <!-- Cover Photo! -->
    <div class="user-wrap-cover">
      


    </div>

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

    <UserExtendedView :user="user"></UserExtendedView>

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
    height : 150px;

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