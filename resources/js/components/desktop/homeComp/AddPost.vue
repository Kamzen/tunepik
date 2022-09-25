<template>
       
  <div class="card no-border">
    
    <!-- Header Of The Card -->
    <div class="card-header no-border">
      
      <span class="app-max-text">
        Compose
      </span>

    </div>

    <!-- Show Contents Of The Card -->
    <div class="card-body no-border">

      <div class="container-fluid">

        <div class="media"> <!-- Main Media -->

          <Picture :user="model" :width="45" :height="45"></Picture>

          <div class="media-body ml-2"> <!-- Media Body -->

            <textarea class="compose-box app-input-field" placeholder="Say Your Peace"></textarea> <!-- Text Area -->

          </div>

        </div> <!-- End Of Media -->

         <div class="space-small"></div>

          <div class="app-compose-buttons media">

            <div class="media-left align-self-center">
              
               <!-- Choose File Button -->
               <label for="media" class="visual-media">
                 <a class="btn btn-sm">
                   <Icon :icon="'gallery'" :width="18" :height="18"></Icon>
                 </a>
               </label>

               <!-- Record Button -->
               <button class="btn btn-sm  rec-btn-lg">
                 <svg-vue icon="micfill" class="app-icon add-post-icons"></svg-vue>
               </button>

            </div>

             <div class="media-body ml-1 align-self-center">
                <v-button :type="'primary'" :large="false" :block="true" class="btn-sm">Share</v-button>
             </div>

          </div> <!-- End Of Add Post Buttons -->

      </div> <!-- End Of Container-Fluid -->

    </div> <!-- End Of Card -->
    
    
  </div> <!--  End Of Card -->

</template>

<script>
  import {mapGetters} from 'vuex';

    export default {
        name: "AddPost",
        computed :{
          ...mapGetters("auth", ['model']),
        }
    };
</script>

<style scoped>

  .add-post-icons{
    width : 18px;
    height : 18px;
  }
  .card{
  }

</style>