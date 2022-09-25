<template>
       
      <nav class="navbar fixed-top navbar-expand-lg wrapper desktop-nav">
        
        <div class="container-fluid">
        <div class="row" style="width:100%;position:relative;top:10px;">
          <div class="col-lg-4 app-icon container-fluid visible-lg">
             
            <table class="app-table" style="background-color: transparent;position: relative;left:40px;">
                <tr>
                  <td class="app-bar-tab" style="padding-left: 10%;width: 15%;">
                      <div class="space-medium"></div>
                      <a class="app-menu-btn">
                          
                      </a>
                  </td>
                  <td class="app-icon-tab" style="padding-left: 5%;">

                      <router-link :to="{ name: user ? 'home' : 'welcome' }">
                        <span class="navbar-brand">
                          {{ appName }}
                        </span>
                      </router-link>
                    
                  </td>
                </tr>
            </table>
              
          </div>
          <div class="col-lg-4 ">
               <!-- <center> -->
                 <div class="search-bar-lg">
                  <table class="app-search-table" style="">
                    <tr>
                      <td class="app-search-tab app-search-icon-tab" style="padding-top: 1%;">
                        <center>
                          <Icon :icon="'search'" :width="20" :height="20"></Icon>
                        </center>
                      </td>
                      <td class="app-search-tab-input" >
                          <input type="search" class="app-input-field app-search-input root" name="search" placeholder="Search TunePik" v-on:keyup="query = $event.target.value" />
                      </td>
                    </tr>
                  </table>
                </div>
              <!-- </center> -->
              <div class="app-dropdown-menu" style="z-index:9999 !important;" v-if="query != ''">
                <SearchView :q="query"></SearchView>
              </div>
            </div>
          <div class="col-lg-4 darkmode-wrapper" style="">

            <div class="row">
              <div class="col-lg-4"></div>
              <div class="col-lg-4">
                
                <div class="loading-wrapper skeleton-shimmer" v-if="loading"></div>

                  <div class="" v-else>

                    <div class="user-wrapper media" v-if="check">
                        
                        <Picture class="align-self-center" :user="model" :height="45" :width="45"></Picture>

                        <div class="media-body pl-2 pb-2 align-self-center">
                          <a @click="show = !show">
                            <user-name :user="model"></user-name>
                          </a>
                          <div class="user-options" style="z-index:9999 !important;" v-if="show">
                            <desktop-user-nav-options :user="model"></desktop-user-nav-options>
                          </div>
                        </div>
                        <div class="media-right align-self-center"></div>
                      
                    </div>

                    <div class="login-wrapper media" v-else>

                      <div class="media-left align-self-center">
                        <v-button :type="'primary'">Login</v-button>
                      </div>
                      <div class="media-right align-self-center pl-2">
                        <v-button :type="'primary'">Create Account</v-button>
                      </div>

                    </div>
                  </div>

              </div>
            </div>
            
          </div>
        </div>
      </div>
  </nav>

</template>

<script>
import { mapGetters } from 'vuex'
import SearchView from '../builders/SearchView'
import DesktopUserNavOptions from '../builders/popupBuilders/DesktopUserNavOptions'

export default {
  name : "DesktopNavBar",
  scrollToTop : false,
  components : {
    SearchView,
    DesktopUserNavOptions
  },
  data: () => ({
    appName : window.config.appName,
    query   : '',
    show : false
  }),
  computed: {
    ...mapGetters("auth", ['user', 'check', 'loading', 'model']),
  },
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

  .loading-wrapper{
    width: 100px;
    height: 40px;
  }

/*  .user-wrapper{
    position: relative;
    top: -8px;
  }
*/
  .search-bar-lg{
    width: 80%;
  }

  .desktop-nav{
    padding-top: 2px;
    padding-bottom: 2px;
  }

  .user-options{
    z-index: 9999 !important;
    position: fixed;
    top: 60px;
    right: 10%;
    width: 15%;
    height: wrap;
    border-radius: 5px;
  }

  .app-dropdown-menu{
    z-index: 9999 !important;
    position: fixed;
    top : 50px;
    border : .04em solid rgba(211, 211, 211, .100);
    width: 350px;
    max-height: 80%;
    overflow-y: auto;
    overflow-x: hidden;
    border-radius: 5px
  }

  .row,
  .container-fluid{
   /* overflow: hidden;*/
    height: 65px;
  }

</style>