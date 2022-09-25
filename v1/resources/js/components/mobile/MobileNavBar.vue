<template>
       
  <div class="navbar app-nav navbar-expand-sm navbar-light bg-white fixed-bottom">

    <table class="app-nav-table darkmode-wrapper pb-2">
      <tr>
        <td class="app-nav-tab home app-tab">
          <center>
            <router-link :to="{ name : 'home' }" >
              <span class="app-home-icon">

                <svg-vue icon="home" class="app-icon" ></svg-vue>

              </span>
              <div class="space-small" ></div>
              <!-- <span class="app-grey-text-sm visible-lg visible-xs icon-text">Home</span> -->

            </router-link>
          </center>
        </td>
        <td class="app-nav-tab search app-tab visible-xs">
            <center>
                <a class="app-search-btn">
                  <div class="space-small" ></div>
                    <span class="app-search-xs">
                     
                     <svg-vue icon="messages" class="app-icon" ></svg-vue>

                    </span>
                    <span class="app-badge msg-badge icon-text icon-badge"></span>
                    <div class="space-small" ></div>
                    <!-- <span class="app-grey-text-sm visible-lg visible-xs icon-text">Search</span> -->
                </a>
            </center>
        </td>
        <td class="app-nav-tab messages app-tab">
          <center>
            <router-link :to="{ name : 'createPost' }" class="app-messages-btn">
              <span class="app-message-icon">

                <svg-vue icon="more" class="app-icon" style="height:36;width:36;" ></svg-vue>
                                    
                </span>         
            </router-link>
          </center>
        </td>
        <td class="app-nav-tab notifications app-tab">
          <center>
            <router-link :to="{ name : 'notifications' }" class="app-notification-btn">
              <span class="app-notification-icon"></span>

                <svg-vue icon="notifications" class="app-icon" ></svg-vue>

                <span class="app-badge notif-badge icon-text icon-badge"></span>
                <div class="space-small" ></div>
                <!-- <span class="app-grey-text-sm visible-lg visible-xs icon-text">Notifs
                </span> -->

            </router-link>
          </center>
        </td>
        <td class="app-nav-tab profile-tab app-tab visible-xs">
            <center>
              <a class="nav-user-link">

                <img class="img-circle nav-user-img" width="30" height="30" />
                <div class="space-small" />
                <span class="app-grey-text-sm visible-lg visible-xs nav-user-handle"></span>
                
              </a>
            </center>
        </td>
        
      </tr>
    </table>
        
  </div>

</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name : "MobileNavBar",
  data: () => ({
    appName: window.config.appName
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
};
</script>

<style scoped>

  .app-icon{
    height : 28px;
    width : 28px;
  }

  .app-nav-table{

    position: relative;
    top: -5px;

  }

</style>