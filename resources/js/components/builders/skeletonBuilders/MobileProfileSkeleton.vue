<template>

	<div class="wrapper">
		
		<Navigation>
			
			<div class="media-body ml-1 align-self-center">
				
				<div class="skeleton-shimmer skeleton-name"></div>
				<div class="handle-shade skeleton-shimmer mt-1"></div>

			</div>
			<div class="media-right align-self-center">
				
				<div class="skeleton-shimmer skeleton-btn nav-btn"></div>
				<div class="skeleton-shimmer skeleton-btn ml-1 nav-btn"></div>

			</div>

		</Navigation>
		<div class="space-large"></div>
		<div class="space-medium"></div>

		<!-- Cover PHOTO -->
		<div class="skeleton-shimmer cover-shade mb-2"></div>

		<!-- USER INFO -->
		<div class="media ml-2">
			
			<div class="skeleton-shimmer media-right skeleton-image"></div>

			<div class="media-body ml-2">
				
				<div class="skeleton-shimmer skeleton-name mt-2"></div>
				<div class="skeleton-shimmer join-shade info-shade mt-1"></div>
				<div class="skeleton-shimmer location-shade info-shade mt-1"></div>

				<div class="space-medium"></div>

				<!-- SHOW FOLLOW STATS -->

				<div class="follow-stats-wrapper">

					<div class="count-shade skeleton-shimmer"></div>
					<div class="text-shade skeleton-shimmer mt-2"></div>
					
				</div>
				<div class="follow-stats-wrapper">
					
					<div class="count-shade skeleton-shimmer"></div>
					<div class="text-shade skeleton-shimmer mt-2"></div>

				</div>

			</div>

		</div>

		<center>
			<div class="bio-shade skeleton-shimmer"></div>
		</center>
		<br />

		<!-- USER STATS -->
		<center>
			<div class="user-stats-wrapper">
			
				<div class="user-stats skeleton-shimmer"></div>
				<div class="user-stats skeleton-shimmer ml-2"></div>
				<div class="user-stats skeleton-shimmer ml-2"></div>

		  </div>
		</center>

		<PostSkeleton></PostSkeleton>

	</div>
	
</template>

<script>

   	import Navigation from '../../mobile/root/Navigation'
   	import PostSkeleton from './PostSkeleton'

		export default {

			name 				: "MobileProfileSkeleton",
			components  : {

				Navigation,
				PostSkeleton

			}

		};
	
</script>

<style scoped>


   .bio-shade{
   	width: 85%;
   	height: 30px;
   	border-radius: 10px;
   }

   .user-stats-wrapper{
   	width: 100%;
   }

   .user-stats{
   	width: 80px;
   	height: 80px;
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

   .skeleton-image{
   	width: 75px;
   	height: 75px;
   	border-radius: 35px;
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
   	width: 100%;
   }
	
</style>