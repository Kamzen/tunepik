<template>

	<AccountBuilder></AccountBuilder>
	
</template>

<script>
		
		import AccountBuilder from '../../../components/builders/profileBuilders/edit/AccountBuilder'

		export default {

				name 				: "Account",
				scrollToTop : false,
				components 	: {

					AccountBuilder

				}

		};
	
</script>

<style scoped>
	
</style>