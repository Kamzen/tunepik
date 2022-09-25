<template>

 <div class="wrapper">
	<div class="card app-suggestions">
    
    <div class="card-header">
      
      <div class="media">
        
        <div class="media-body">
          
          <span class="app-max-text">
            Suggestions
          </span>

        </div>
        <div class="media-right">
          
          <a @click="grid = !grid">
                
            <Icon :icon="grid ? 'list' : 'grid'" :width="24" :height="24"></Icon>

          </a>

        </div>

      </div>

    </div>


    <div class="card-body">

      <div class="" v-if="loading">
        
        <GridSkeleton :cols="2" v-if="grid"></GridSkeleton>
        <UserListSkeleton v-else></UserListSkeleton>

      </div>
    
      <div class="" v-else>
        
        <template v-if="error">
          <span>
            {{ message }}
          </span>
        </template>
        <template v-else>

          <UserListBundler :message="message" :users="Users" :showGrid="grid"></UserListBundler>

        </template>

      </div>

    </div>

  </div>

 </div>
	
</template>

<script>
	 
	 import { mapGetters, mapActions } from 'vuex'
   import UserListBundler from '../../builders/userBuilders/UserListBundler'
   import UserListSkeleton from '../../builders/skeletonBuilders/UserListSkeleton'
   import GridSkeleton from '../../builders/skeletonBuilders/GridSkeleton'
	
	export default {

		name : 'MobileSuggestions',
    data : () => ({
      grid : true
    }),
		components : {

			UserListBundler,
      UserListSkeleton,
      GridSkeleton

		},
		methods     : {

          ...mapActions("follow", ['getSuggestions'])

    },
    computed    : {

      ...mapGetters("follow", ['loading', 'error', 'Users', 'list', 'message']),

    },
    created     : function () {

          this.getSuggestions();

    }

	};

</script>

<style scoped>

  .card-body{

    padding: 0;
    border : 0;

  }
  .card-header{

    border-bottom: 0;
    border: 0;

  }
  .card{

    box-shadow: 0 0 0 0 transparent;
    border-bottom: 0;
    border : 0;

  }

</style>