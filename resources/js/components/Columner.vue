<template>

		<div class="row">
			
			<div :class="[columns.one]">
				<slot></slot>
			</div>
			<div :class="[columns.two]"></div>

		</div>
	
</template>

<script type="text/javascript">

	import { mapGetters } from 'vuex'
	export default {
		name : "Columner",
		computed : {
			...mapGetters('tunepik', ['columns'])
		}
	};
	
</script>

<style type="text/css" scoped></style>