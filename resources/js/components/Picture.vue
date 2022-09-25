<template>

	<div class="image-wrapper" v-if="user"> 
		
		<a @click="show = !show">

		<image-loader 
				:height="height + 'px'"
				:width="width + 'px'"
				:placeholder="user.getImgs().profile"
				:src="user.getImgs().profile"
				class="rounded-circle"
				/>

		</a>

		<!-- <ProfileSnippet :user="user" :show="show"></ProfileSnippet> -->

	</div>
	
</template>

<script type="text/javascript">

		/*import ProfileSnippet from './builders/snippets/ProfileSnippet'*/

		export default {

			name  		: "Picture",
			data      : () => ({

				show  : false

			}),
			/*components : {
				ProfileSnippet
			},*/
			props : ['height', 'width', 'user'],
			computed : {
			}

		};
	
</script>

<style type="text/css" scoped></style>