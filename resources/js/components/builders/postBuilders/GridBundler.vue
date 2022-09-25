<template>
	
	<div class="" v-if="loading">
		
		<GridSkeleton :cols="3"></GridSkeleton>

	</div>
	<div class="" v-else>
		
		
		<div class="app-deleted-post grey-matter" v-if="error">
			
			<div class="space-large"></div>
		   
		    <center>
		    	<span class="app-post-text">
		    		{{ message }}
		    	</span>
		    </center>

		</div>
		<div class="grid-wrapper" v-else>
	
			<masonry
			   :cols="{default : 3, 1000 : 3, 700 : 3, 400 : 3}"
			   :gutter="{default : '0px', 700 : '0px', 400 : '0px'}"
					>

					<template v-for="post in posts">
				
						<div :class="['gridItem']" class="grid-video" v-if="post.getPost().type == 'video'">
							
							 <video controls="false">
							 	
							 	<source :src="post.getPost().url">

							 </video>

						</div>
						<div :class="['gridItem']" class="grid-image" v-else-if="post.getPost().type == 'image' || post.getPost().type == 'photo'">
							
							<img :src="post.getPost().url" height="100%" width="100%">

						</div>

					</template>
						
			</masonry>

		</div>

	</div>
		
</template>

<script>

	import globs from '../../../tunepik/attack.js'
	import GridSkeleton from '../skeletonBuilders/GridSkeleton'

	export default {

		name 		: "GridBundler",
		components : {

			GridSkeleton

		},
		data 		: function(){

			return {

				gridItemImage : 'grid-item-image',
				gridItemVideo : 'grid-item-video',
				gridItem 			: 'grid-item'

			};

		},
		props 	: ['posts', 'loading', 'message', 'error'],
		mounted : function(){

		}

	};
	
</script>

<style scoped>

   .grid-item{

   	width: 33.9%;

   }

   .grid-image,
   .grid-video{
   	 margin: 1.5px
   }
	
</style>