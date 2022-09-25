<template>
       
  <div class="app-right-side-view">

    <AddPost ></AddPost>

    <div class="space-medium"></div>

    <Suggestions ></Suggestions>

  </div>

</template>

<script>
  import {mapGetters} from 'vuex';
  import AddPost from './AddPost'
  import Suggestions from './Suggestions'

    export default {
        name: "RightSideBuilder",
        components : {

          AddPost,
          Suggestions

        }
        
    }
</script>

<style scoped>

    .app-right-side-view{

      position: fixed;
      width : 28%;

    }

</style>