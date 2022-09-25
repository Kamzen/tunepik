<template>
       
      <div class="app-icon-nav">
        <table class="app-nav-table darkmode-wrapper icon-table">
            <tr>
              <td class="app-nav-tab home app-tab-nav">
                <center>
                    <div class="space-small" />
                    <div class="space-small" />
                  <router-link :to="{ name : 'home' }">
                      <span class="app-home-icon">

                        <svg-vue icon="home" class="app-icon" ></svg-vue>

                      </span>
                      <br />
                      <span class="app-grey-text-sm visible-lg icon-text">Home</span>
                  </router-link>
                </center>
              </td>

            </tr>
              <td class="app-nav-tab messages app-tab-nav">
                <center>
                    <div class="space-small" />
                    <div class="space-small" />
                  <a class="app-messages-btn">
                    <span class="app-message-icon">
                       <svg-vue icon="messages" class="app-icon" ></svg-vue>
                    </span>
                    <br />
                    <span class="app-badge msg-badge icon-text icon-badge"></span>

                    <span class="app-grey-text-sm visible-lg icon-text">Messages
                    </span>
                            
                  </a>
                </center>
              </td>
            <tr>
              <td class="app-nav-tab notifications app-tab-nav">
                <center>
                  <router-link :to="{ name : 'notifications'}" class="app-notification-btn">
                    <span class="app-notification-icon">
                        <svg-vue icon="notifications" class="app-icon" ></svg-vue>
                    </span>
                    <br />
                    <span class="app-badge notif-badge icon-text icon-badge"></span>
                    <span class="app-grey-text-sm visible-lg icon-text">Notifications</span>
                  </router-link>
                </center>
              </td>
            </tr>
            <tr>
                <td class="app-nav-tab trending app-tab-nav">
                    <center>
                        <a class="trending-hash">
                            <span class="app-hash-icon app-max-text" style="font-size: 19pt;">
                                #
                            </span>
                            <br />
                            <span class="app-grey-text-sm">Trending</span>
                        </a>
                    </center>
                </td>
            </tr>
            <tr>
                <td class="app-nav-tab profile-tab app-tab-nav">
                    <center>
                      <a class="nav-user-link">
                        <img class="img-circle nav-user-img" width="30" height="30" />
                        <span class="app-grey-text-sm visible-lg nav-user-handle"></span>
                      </a>
                    </center>
                </td>
              
            </tr>
            <!-- <tr>
                <td class="app-nav-tab trending app-tab-nav">
                    <center>
                        <a class="trending-hash">
                            <span class="app-hash-icon">
                                
                            </span>
                            <span class="app-grey-text-sm"></span>
                        </a>
                    </center>
                </td>
            </tr>
            <tr>
                <td class="app-nav-tab trending app-tab-nav">
                    <center>
                        <a class="trending-hash">
                            <span class="app-hash-icon">
                                
                            </span>
                            <span class="app-grey-text-sm"></span>
                        </a>
                    </center>
                </td>
            </tr>
            <tr>
                <td class="app-nav-tab trending app-tab-nav">
                    <center>
                        <a class="trending-hash">
                            <span class="app-hash-icon">
                                
                            </span>
                            <span class="app-grey-text-sm"></span>
                        </a>
                    </center>
                </td>
            </tr> -->
            </table>
        
      </div>

</template>

<script>
  import {mapGetters} from 'vuex';

    export default {
        name: "IconNav",
        
    }
</script>

<style scoped>

   .app-tab-nav{

    width: 60px;
    height: 66px;

  }

  .icon-text {

    padding-top : 10px;

  }

  .app-nav-table{
    position: fixed;
    top: 160px;
    left : 180px;
    width : 100px;
    padding-top: 2%;
    padding-bottom: 2%;
    border-radius: 2px;
    -webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, .175);
    box-shadow: 0 2px 4px rgba(0, 0, 0, .175);
    background-color : #fff
  }

</style>