<template>


  <div class="" v-if="profile.loading"> <!-- profile.loading -->
     
     <div class="" v-if="screen">

      <MobileProfileSkeleton></MobileProfileSkeleton>
       
     </div>
     <div class="" v-else>
       
       <DesktopProfileSkeleton></DesktopProfileSkeleton>

     </div>

  </div>
  <div class="" v-else>
    
     <template v-if="screen">

       <MobileProfileView :user="profile.model"></MobileProfileView>
       
     </template>
     <template v-else>

      <div class="space-large"></div>
      <div class="space-large"></div>
      <div class="space-large"></div>
      <DesktopProfileView :user="profile.model"></DesktopProfileView>
       
     </template>

  </div>


	
</template>


<script>

  import { mapGetters, mapActions } from 'vuex'
  import globs from '../../../tunepik/attack.js'
  import DesktopProfileView from '../../desktop/profileComp/DesktopProfileView'
  import MobileProfileView from '../../mobile/profileComp/MobileProfileView'
  import MobileProfileSkeleton from '../skeletonBuilders/MobileProfileSkeleton'
  import DesktopProfileSkeleton from '../skeletonBuilders/DesktopProfileSkeleton'
	
	export default {

		name   : "ProfileBundler",
		data : function(){

          return {

            username : null,
            screen : globs.app.isMobile

          }

        },
        components : {

          DesktopProfileView,
          MobileProfileView,
          MobileProfileSkeleton,
          DesktopProfileSkeleton

        },
        computed : {

          UserName : function(){

            this.username = this.$route.params.username

            return this.username;

          },
          ...mapGetters("profile", ["profile"])

        },
        methods : {

          ...mapActions("profile", ["setUserProfile", "getUserProfile"])

        },
        created(){

           this.getUserProfile(this.UserName);

        },
        watch : {

          '$route.params.username'(newUsername, oldUsername){

            this.UserName = newUsername;

            this.getUserProfile(this.UserName);

          }

        }

	}

</script>

<style scoped>

</style>