<template>


  <div class="" v-if="profile.loading"> <!-- profile.loading -->
     
     <div class="" v-if="screen">

      <mobile-profile-skeleton></mobile-profile-skeleton>
       
     </div>
     <div class="" v-else>
       
       <desktop-profile-skeleton></desktop-profile-skeleton>

     </div>

  </div>
  <div class="" v-else>
    
     <template v-if="screen">

       <mobile-profile-view :user="profile.model"></mobile-profile-view>
       
     </template>
     <template v-else>

      <!-- <div class="space-large"></div>
      <div class="space-large"></div>
      <div class="space-large"></div> -->
      <desktop-profile-view-two :user="profile.model"></desktop-profile-view-two>
       
     </template>

  </div>

</template>

<script>

  import { mapGetters, mapActions, mapMutations } from 'vuex'
  import globs from '../../../tunepik/attack.js'
  import DesktopProfileView from '../../desktop/profileComp/DesktopProfileView'
  import MobileProfileView from '../../mobile/profileComp/MobileProfileView'
  import DesktopProfileViewTwo from '../../desktop/profileComp/DesktopProfileViewTwo'
  import MobileProfileSkeleton from '../skeletonBuilders/MobileProfileSkeleton'
  import DesktopProfileSkeleton from '../skeletonBuilders/DesktopProfileSkeleton'
	
	export default {

		name   : "ProfileBundler",
		data : () => ({
      username : null,
      screen : globs.app.isMobile
    }),
    components : {
      DesktopProfileView,
      MobileProfileView,
      MobileProfileSkeleton,
      DesktopProfileSkeleton,
      DesktopProfileViewTwo
    },
    computed : {
      UserName : function(){
        this.username = this.$route.params.username
        return this.username;
      },
      ...mapGetters("profile", ["profile",])
    },
    methods : {
      ...mapActions("profile", ["setUserProfile", "getUserProfile", "MAIN_USER", "getUserPosts", "purge"]),
      ...mapMutations('profile', ['setUserLoading'])
    },
   created(){
     this.MAIN_USER(this.UserName)

     if(!this.profile.model){

      this.getUserProfile(this.UserName)

     }
    },
    watch : {
      '$route.params.username'(newUsername, oldUsername){

        this.UserName = newUsername;
        this.purge()

        if(!this.MAIN_USER(this.UserName)){

          this.getUserProfile(this.UserName)

         }

         if(this.UserName == this.profile.model.getBasic().handle) this.getUserPosts({ url : `/api/posts/user/${this.profile.model.getBasic().id}/`})

      }

    }

	};

</script>

<style scoped>

</style>