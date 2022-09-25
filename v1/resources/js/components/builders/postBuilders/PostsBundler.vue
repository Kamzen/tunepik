<template>


	    <div v-if="type == 'list'">
	    	
	    	<div class="" v-if="loading">

         <PostSkeleton></PostSkeleton>

       </div>
       <div v-else>
         
          <div v-if="list" class="posts">

            <template v-for="(PostModel, index) in posts">

              <post :post="PostModel" :comments="true" ></post>

            </template>
            
         </div>
         <div v-else>
           
           <div class="space-large"></div>
           <div class="app-deleted-post grey-matter">
              
              <center>
              	<span class="app-max-text">
              		{{ message }}
              	</span>
              </center>

           </div>

         </div>

       </div>

	    </div>

	    <div v-else>
	    	
	    	GRIDD

	    </div>
	
</template>

<script>

   import Post from '../Post'
   import PostSkeleton from '../skeletonBuilders/PostSkeleton'

		export default {

			name    : "PostsBundler",
			components : {

				Post,
        PostSkeleton

			},
			props   : ['posts', 'list', 'type', 'loading','message']

		};
	
</script>

<style scoped>
	
</style>