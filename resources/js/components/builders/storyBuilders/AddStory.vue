<template>

	<div class="wrapper">
		<center>
			<div class="dropdown">

				<a class="dropdown-toggle" href="#" data-toggle="dropdown">

					<Picture :user="model" :height="70" :width="70"></Picture>

    		</a>
		    <div class="dropdown-menu wrapper">
		      <a class="dropdown-item" href="#">

		      	<router-link :to="{ name : 'story', params : { username : model.getBasic().handle } }">
		      		<span class="app-post-text">
		      			Add Your Story
		      		</span>
		      	</router-link>

		      </a>
		      <a class="dropdown-item" href="#">

		      	<router-link :to="{ name : 'stories', params : { username : model.getBasic().handle, id : model.getBasic().id } }">
		      		<span class="app-post-text">
		      			View Your Story
		      		</span>
		      	</router-link>

		      </a>
		    </div>
				
			</div>
		</center>
	</div>
	
</template>

<script type="text/javascript">
	
	import { mapGetters } from 'vuex'
	export default {
		name 		: "AddStory",
		computed : {
			...mapGetters("auth", ['model']),
		}
	};

</script>

<style type="text/css" scoped></style>