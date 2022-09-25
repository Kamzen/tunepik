<template>
       
  <div class="wrapper-view row">
    <!-- Cover Photo! -->
    <div class="user-wrap-cover">
      
    </div>

    <!-- Show Info About User -->
  <div class="scroll-wrapper">

    <div class="card">
      
      <div class="card-header">
        
        <UserNavBuilder :user="user"></UserNavBuilder>

      </div>

    <div class="card-body">
      
       <UserInfoBuilder :user="user">
         
         <UserFollowsBuilder :user="user"></UserFollowsBuilder>

       </UserInfoBuilder>

       <div class="space-small"></div>

       <center>
         <UserStatsBuilder :user="user"></UserStatsBuilder>
       </center>

    </div>

    </div>

     <UserExtendedView :user="user" ></UserExtendedView>

  </div>
  
  </div>

</template>

<script>

   import UserInfoBuilder from '../../builders/profileBuilders/UserInfoBuilder'
   import UserFollowsBuilder from '../../builders/profileBuilders/UserFollowsBuilder'
   import UserExtendedView from '../../builders/profileBuilders/UserExtendedView'
   import UserStatsBuilder from '../../builders/profileBuilders/UserStatsBuilder'
   import UserNavBuilder from '../../builders/profileBuilders/UserNavBuilder'

    export default {
        name: "DesktopProfileView",
        components : {

          UserFollowsBuilder,
          UserStatsBuilder,
          UserInfoBuilder,
          UserNavBuilder,
          UserExtendedView

        },
        props : ['user']
        
    };
</script>

<style scoped>


  .user-wrap-cover{

    border : .05em solid lightgrey;
    height : 250px;

  }

  .scroll-wrapper{

    width : 90%;
    position : relative;
    top : -100px;
    left : 45px;

  }

  .card-header{
    padding : 0;
  }

</style>