<template>
	<center>
		<div class="app-loader" :style="border"></div>
	</center>
</template>

<script type="text/javascript">
	
	import { mapGetters } from 'vuex'

	export default {
		name : "Spinner",
		computed : {
			...mapGetters('tunepik', ['theme']),
			border : function(){
				return { border : `5px solid ${theme.icons.color}` }
			}
		}
	};

</script>

<style type="text/css" scoped>
	
</style>