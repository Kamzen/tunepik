<template>
       
  <div class="card app-suggestions">
    
    <div class="card-header">
      
      <span class="app-max-text">
        Suggestions
      </span>

    </div>


    <div class="card-body">

      <div class="" v-if="loading">
        
         Loading...

      </div>
    
      <template v-if="error">
          <span>
            {{ message }}
          </span>
      </template>
      <template v-else>

        <CardSlideBundler :users="Users" ></CardSlideBundler>

      </template>

    </div>

  </div>

</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  /*import CardSlideBundler from '../../builders/userBuilders/CardSlideBundler.vue'*/

    export default {

        name        : "Suggestions",
        /*component   : {

          CardSlideBundler

        } */
        methods     : {

          ...mapActions("follow", ['getSuggestions'])

        },
        computed    : {

          ...mapGetters("follow", ['loading', 'error', 'Users', 'list', 'message']),

        },
        created     : function () {

          if(!this.list){

            this.getSuggestions();

          }

        }
        
    }
</script>

<style scoped>

  .card{

    border : .05em solid lightgrey;

  }

</style>