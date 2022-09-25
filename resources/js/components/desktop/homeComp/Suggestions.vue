<template>
       
  <div class="card app-suggestions no-border">
    
    <div class="card-header">
      
      <div class="media">
        
        <div class="media-body align-self-center">
           <span class="app-max-text">
              Suggestions
           </span>
        </div>
        <div class="media-right align-self-center">
          <Icon :icon="'grid'" :width="24" :height="24"></Icon>
        </div>

      </div>

    </div>

    <div class="card-body">

      <div v-if="loading">
         <slide-skeleton></slide-skeleton>
      </div>
      <div class="" v-else>
          
          <template v-if="error">
            
            <div class="app-deleted-post grey-matter">
              <center>
                <span>
                  {{ message }}
                </span>
              </center>
            </div>

          </template>
          <template v-else>

            <card-slide-bundler :users="Users" ></card-slide-bundler>

          </template>

      </div>
    
    </div>

  </div>

</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  // import SlideSkeleton from '../../builders/skeletonBuilders/SlideSkeleton'

    export default {

        name        : "Suggestions",
        component   : {

          // SlideSkeleton

        } ,
        methods     : {

          ...mapActions("follow", ['getSuggestions'])

        },
        computed    : {

          ...mapGetters("follow", ['loading', 'error', 'Users', 'list', 'message']),

        },
        created     : function () {

          this.$nextTick(function(){

            if(!this.list){

              this.getSuggestions();

            }

          });

        }
        
    };
</script>

<style scoped>

  @media only screen and (max-width: 700px){

    .card{

      border : 0;

    }

    .card-body{

      padding: 0;

    }

  }

  @media only screen and (min-width: 700px){

    .card{

      /*border : 0;*/

    }

    .card-body{

      padding: 0;

    }

  }

</style>