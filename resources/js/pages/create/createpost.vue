<template>


	<div class="root-element">
		
		<AddPost></AddPost>

	</div>
	

</template>


<script>

 import AddPost from '../../components/mobile/root/AddPost'

 export default {

 	name : "CreatePost",
 	scrollToTop : false,
 	components : {
 		AddPost
 	}

 };
	

</script>


<style scoped>
	
</style>