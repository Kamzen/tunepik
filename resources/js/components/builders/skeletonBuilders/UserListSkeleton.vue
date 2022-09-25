<template>

	<div class="wrapper list-group">
		
		<template v-for="item in limit">

			<div class="list-group-item skeleton-wrapper">
				
				<div class="media align-self-center">
					
					<div class="skeleton-image skeleton-shimmer"></div>
					<div class="media-body ml-2">
						
						<div class="skeleton-name skeleton-shimmer"></div>
						<div class="skeleton-shimmer bio-shade mt-1 pr-3"></div>

					</div>

					<div class="skeleton-shimmer skeleton-btn"></div>

				</div>

			</div>

		</template>

	</div>
	
</template>

<script>

		import globs from '../../../tunepik/attack.js'
		
		export default {

			name 			: "UserListSkeleton",
			data 			: function(){
				return {
					limit : globs.limit,
				};
			}

		};

</script>

<style scoped>


		.list-group-item{

			border : 0;
			padding: 5px;

		}

		.bio-shade{
			width: 80%;
			height: 35px;
			border-radius: 14px;
		}

	
</style>