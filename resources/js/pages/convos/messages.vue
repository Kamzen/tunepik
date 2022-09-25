<template>

	<messages-list></messages-list>
	
</template>

<script type="text/javascript">

		import MessagesList from '../../components/builders/chatsBuilders/MessagesList'

		export default {

				name 				: "Messages",
				scrollToTop : false,
				components 	: {

					MessagesList

				}

		};
	
</script>

<style type="text/css" scoped>
	
</style>