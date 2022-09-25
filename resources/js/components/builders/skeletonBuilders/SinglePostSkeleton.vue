<template>
	
	<div class="skeleton-wrapper mb-2">

			<!-- POST HEADER -->
				
				<div class="media p-2">
				
					<div class="media-left img-shade skeleton-shimmer skeleton-image"></div>
					
					<div class="media-body ml-3 align-self-center">
						
						<div class="skeleton-shimmer skeleton-name"></div>
						<div class="skeleton-shimmer date-shade mt-1"></div>

					</div>
					<div class="media-right align-self-center">
					
						<div class="options-shade skeleton-shimmer"></div>

					</div>

				</div>

				<!-- MAIN POST -->
				<div class="post-shade skeleton-shimmer mb-2 mt-1"></div>

				<!-- POST REACTION -->
				<div class="media">
					
					<div class="media-left skeleton-shimmer reactions-shade ml-3">
						


					</div>
					<div class="media-body">
						
						<center>
							<span class="skeleton-shimmer reactions-count-shade"></span>
						</center>

					</div>
					<div class="media-right skeleton-shimmer share-shade mr-3"></div>

				</div>

				<div class="space-medium"></div>

			</div>

</template>

<script>

	export default {

		name 			: "SinglePostSkeleton",

	};
	
</script>

<style scoped>

	.skeleton-wrapper{

  	border-bottom: .05em solid rgba(211, 211, 211, .4)

  }

  .date-shade{
  	width: 100px;
  	height: 15px;
  	border-radius: 6px;
  }

  .options-shade{
  	width: 20px;
  	height: 20px;
  	border-radius: 15px;
  }

	.post-shade{
		width: 100%;
		height: 250px;
	}

	.share-shade{

		width: 50px;
		height: 30px;
		border-radius: 20px;
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 7px;
    padding-right: 7px;
	}
	.reactions-shade{

		width: 100px;
		height: 30px;
		border-radius: 20px;
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 7px;
    padding-right: 7px;

	}
	
</style>