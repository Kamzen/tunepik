<template>

 <div class="wrapper">
	<div class="card app-suggestions">
    
    <div class="card-header">
      
      <span class="app-max-text">
        Suggestions
      </span>

    </div>


    <div class="card-body">

      <div class="" v-if="loading">
        
        <UserListSkeleton></UserListSkeleton>

      </div>
    
      <div class="" v-else>
        
        <template v-if="error">
          <span>
            {{ message }}
          </span>
        </template>
        <template v-else>

          <UserListBundler :message="message" :users="Users" ></UserListBundler>

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
	
	export default {

		name : 'MobileSuggestions',
		components : {

			UserListBundler,
      UserListSkeleton

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

  }
  .card-header{

    border-bottom: 0;

  }
  .card{

    box-shadow: 0 0 0 0 transparent;
    border-bottom: 0;

  }

</style>