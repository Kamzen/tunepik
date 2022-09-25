<template>
  
  <div class="wrapper">

     <div class="user-user-media-stats-wrapper" :class="[screen ? 'grey-matter' : '']">
      <table class="app-full-user-info-body" style="border: 0;height: 45px;">
          <tr class="">

            <td class="stats-tab" style="">

              <center>
                <router-link :to="{ name : 'grid', params : { type : 'image' } }" class="camera-btn media-btn">
                  <!-- <svg-vue icon="gallery" class="app-icon user-stats-icon"></svg-vue> -->
                  <Icon :icon="'gallery'" :width="32" :height="32"></Icon>
                  <br />
                  <span class="app-bolder-text"> {{ user.getMedia().images }} </span>
                </router-link>
              </center>

            </td>
            <td class="stats-tab">

              <center>
                <router-link :to="{ name : 'grid', params : { type : 'video' } }" class="video-btn media-btn">
                  <!-- <svg-vue icon="video" class="app-icon user-stats-icon"></svg-vue> -->
                  <Icon :icon="'video'" :width="32" :height="32"></Icon>
                  <br />
                  <span class="app-bolder-text"> {{ user.getMedia().videos }} </span>
                </router-link>
              </center>

            </td>
            <td class="stats-tab">

              <center>

                <router-link :to="{ name : 'grid', params : { type : 'audio' } }" class="audio-btn media-btn">
                  <!-- <svg-vue icon="audio" class="app-icon user-stats-icon"></svg-vue> -->
                  <Icon :icon="'audio'" :width="32" :height="32"></Icon>
                  <br />
                  <span class="app-bolder-text"> {{ user.getMedia().audios }} </span>
                </router-link>

              </center>
            </td>
          </tr>
        </table>
      </div>

  </div>

</template>

<script type="text/javascript">

 import globs from '../../../tunepik/attack.js'

  export default {

    name : "UserFollowsBuilder",
    data : () => ({
      screen : false//,
    }),
    props : ['user']

  };
  

</script>

<style scoped>

   .user-stats-icon{

    width : 32px;
    height : 32px;

   }

   @media only screen and (min-width: 700px){

    .app-full-user-info-body{

      width: 60%;

    }

   }

   @media only screen and (max-width: 700px){

    .app-full-user-info-body{

      width: 100%;

    }

    .user-user-media-stats-wrapper{
      width: 90%;
      border-radius: 10px;
    }


   }
</style>