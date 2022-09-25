<template>
       
  <div class="card">
    
    <!-- Header Of The Card -->
    <div class="card-header">
      
      <span class="app-max-text">
        Compose
      </span>

    </div>

    <!-- Show Contents Of The Card -->
    <div class="card-body">

      <div class="container-fluid">

        <div class="media"> <!-- Main Media -->

            <img height="35" width="35" class="compose-img rounded-circle img-fluid" />

          <div class="media-body ml-2"> <!-- Media Body -->

            <textarea class="compose-box app-input-field" placeholder="Say Your Peace"></textarea> <!-- Text Area -->

          </div>

        </div> <!-- End Of Media -->

         <div class="space-small"></div>

          <div class="app-compose-buttons media">

            <!-- Add Post Button -->

             <!-- Choose File Button -->
             <label for="media" class="visual-media">

               <a class="btn btn-sm">
                 
                 <svg-vue icon="wallpaper" class="app-icon add-post-icons"></svg-vue>

               </a>

             </label>

             <!-- Record Button -->
             <button class="btn btn-sm  rec-btn-lg ml-1">

               <svg-vue icon="micfill" class="app-icon add-post-icons"></svg-vue>

             </button>

             <div class="media-body ml-1">
                <!-- Upload Button -->

                 <button class="btn btn-sm btn-info compose-btn" style="width:100%;">

                   Share

                 </button>

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
        
    }
</script>

<style scoped>

  .add-post-icons{
    width : 18px;
    height : 18px;
  }
  .card{
    border : .05em solid lightgrey;
  }

</style>