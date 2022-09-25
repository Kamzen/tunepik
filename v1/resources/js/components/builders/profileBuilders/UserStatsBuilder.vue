<template>
  
  <div class="wrapper">

     <div class="user-user-media-stats-wrapper">

      <table class="app-full-user-info-body" style="border: 0;height: 45px;">
          <tr class="">

            <td class="stats-tab" style="">

              <center>

                <a class="camera-btn media-btn">

                  <svg-vue icon="gallery" class="app-icon user-stats-icon"></svg-vue>
                  <br />
                  <span class="app-max-text"> {{ user.getMedia().images }} </span>

                </a>

              </center>

            </td>

            <td class="stats-tab">

              <center>

                <a class="video-btn media-btn">

                  <svg-vue icon="video" class="app-icon user-stats-icon"></svg-vue>
                  <br />
                  <span class="app-max-text"> {{ user.getMedia().videos }} </span>

                </a>

              </center>

            </td>

            <td class="stats-tab">

              <center>

                <a class="audio-btn media-btn">

                  <svg-vue icon="audio" class="app-icon user-stats-icon"></svg-vue>
                  <br />
                  <span class="app-max-text"> {{ user.getMedia().audios }} </span>

                </a>

              </center>

            </td>

          </tr>

        </table>

      </div>

  </div>

</template>

<script type="text/javascript">

  export default {

    name : "UserFollowsBuilder",
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


   }
</style>