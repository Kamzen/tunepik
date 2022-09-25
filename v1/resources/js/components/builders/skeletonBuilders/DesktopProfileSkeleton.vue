<template>

	<div class="wrapper">
		
		<div class="space-large"></div>
		<div class="space-large"></div>
		<div class="space-large"></div>
		<!-- COVER IMAGE -->
		<div class="skeleton-shimmer cover-shade"></div>

		<!-- USER INFO -->
		<div class="user-info-wrapper">
			
			<div class="card">
				
				<div class="card-header">
					
					<!-- NAVIGATION -->

					<div class="media ml-6">
						
						<div class="media-left align-self-center">
							
							<a class="back-btn">
								<svg-vue icon="back" class="app-icon"></svg-vue>
							</a>

						</div>
						<div class="media-body ml-2">
							
							<div class="skeleton-shimmer skeleton-name"></div>
							<div class="skeleton-shimmer handle-shade mt-1"></div>

						</div>
						<div class="media-right">
							
							<div class="skeleton-shimmer skeleton-btn nav-btn"></div>
							<div class="skeleton-shimmer skeleton-btn nav-btn ml-2"></div>

						</div>

					</div>

				</div>
				
				<!-- TRUE USER INFO -->
				<div class="card-body">
					
					<div class="media">
						
						<div class="media-right skeleton-shimmer skeleton-image"></div>

						<div class="media-body ml-2 align-self-center">
							
							<div class="skeleton-shimmer skeleton-name"></div>
							<div class="skeleton-shimmer info-shade mt-2"></div>
							<div class="skeleton-shimmer info-shade mt-2"></div>

						</div>

					</div>

					<center>
						
						<div class="follow-stats-wrapper">
							
							<div class="count-shade skeleton-shimmer"></div>
					    <div class="text-shade skeleton-shimmer mt-2"></div>

						</div>
						<div class="follow-stats-wrapper">
							
							<div class="count-shade skeleton-shimmer"></div>
					    <div class="text-shade skeleton-shimmer mt-2"></div>

						</div>

						<br />

						<div class="bio-shade skeleton-shimmer"></div>

						<div class="user-stats-wrapper mt-3">
			
							<div class="user-stats skeleton-shimmer"></div>

							<div class="user-stats spacer"></div>

							<div class="user-stats skeleton-shimmer ml-2"></div>

							<div class="user-stats spacer"></div>

							<div class="user-stats skeleton-shimmer ml-2"></div>

					  </div>

					</center>

				</div>

			</div>

			<div class="space-small"></div>

			<div class="row">
				
				<div class="col-lg-8">
					
					<PostSkeleton></PostSkeleton>

				</div>
				<div class="col-lg-4 skeleton-shimmer cover-shade"></div>

			</div>

		</div>

	</div>
	
</template>

<script>

	  import PostSkeleton from './PostSkeleton'

		export default {

			name 				: "DesktopProfileSkeleton",
			components  : {

				PostSkeleton

			},

		};
	
</script>

<style scoped>


  .user-info-wrapper{
  	width : 90%;
    position : relative;
    top : -100px;
    left : 45px;
  }

  .bio-shade{
   	width: 85%;
   	height: 30px;
   	border-radius: 10px;
   }

   .user-stats-wrapper{
   	width: 100%;
   }

   .user-stats{
   	width: 50px;
   	height: 50px;
   	border-radius: 15px;
   	display: inline-block;
   }

   .follow-stats-wrapper{
   	display: inline-block;
   }

   .count-shade{
   	width: 30px;
   	height: 20px;
   	border-radius: 9px;
   }

   .text-shade{
   	width: 80px;
   	height: 15px;
   	border-radius: 7.5px;
   }

   .skeleton-btn{
   	width : 140px;
   }

   .skeleton-image{
   	width: 140px;
   	height: 140px;
   	border-radius: 70px;
   }
   .nav-btn{
   	display: inline-block;
   }

   .info-shade{
   	width: 80%;
   	height: 15px;
   	border-radius: 5px;
   }
   .handle-shade{
   	width: 40%;
   	height: 10px;
   	border-radius: 5px;
   }

   .cover-shade{
   	height: 250px;
   }

	
</style>