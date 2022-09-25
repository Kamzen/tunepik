<template>
       
      <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-white">
        
        <div class="container-fluid">
        <div class="row" style="width:100%;position:relative;top:10px;">
                <div class="col-lg-4 app-icon container-fluid visible-lg">
                   
                        <table class="app-table" style="background-color: transparent;position: relative;left:40px;">
                            <tr>
                                <td class="app-bar-tab" style="padding-left: 10%;width: 15%;">
                                    <div class="space-medium"></div>
                                    <span class="">
                                    <a class="app-menu-btn">
                                        
                                    </a>
                                    <span class="app-grey-text-sm icon-text" style="position: relative;top: -12px;">Menu</span>
                                    </span>
                                </td>
                                <td class="app-icon-tab" style="padding-left: 5%;">

                                    <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
                                      {{ appName }}
                                    </router-link>
                                  
                                </td>
                            </tr>
                        </table>
                    
                </div>
          <div class="col-lg-4 ">
                    <center>
                        <div class="search-bar-lg">
                        <table class="app-search-table" style="">
                            <tr>
                                <td class="app-search-tab app-search-icon-tab" style="padding-top: 1%;">
                                    <center>
                                        <span class="app-search-lg">
                                          <svg-vue icon="search" class="app-icon" ></svg-vue>
                                        </span>
                                    </center>
                                </td>
                                <td class="app-search-tab-input">
                                    <input type="search" class="app-input-field app-search-input" name="search" placeholder="Search TunePik"  />
                                </td>
                            </tr>
                        </table>
                      </div>
                    </center>
                        <br />
                        <div class="app-search-dropdown">
                            <div class="app-header">
                                <div class="media">
                                    <div class="media-left search-remove-icon">remove</div>
                                    <div class="media-body"></div>
                                    <div class="media-right"></div>
                                </div>
                            </div>
                            <div class="space-small"></div>
                            <div class="dropdown-view"></div>
                        </div>
                </div>
          <div class="col-lg-4 darkmode-wrapper" style="">

                    <table class="" style="width: 75%;">
                        <tr>
                          <td class="app-navi-tab">
                            
                          </td>
                        </tr>
                    </table>
            
          </div>
        </div>
      </div>
  </nav>

</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name : "DesktopNavBar",

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
}
</script>

<style scoped>

</style>