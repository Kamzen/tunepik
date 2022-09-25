<template>

		<i class="app-fa fa fa-certificate" v-if="user.getInfo().verified"></i>
		<i v-else></i>
	
</template>

<script type="text/javascript">

	export default {

		name : "Verified",
		props : ['user'],

	};
	
</script>

<style type="text/css" scoped>
	.app-fa{
		width: 15px;
		height: 15px;
	}
</style>