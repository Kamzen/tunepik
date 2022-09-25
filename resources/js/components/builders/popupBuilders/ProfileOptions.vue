<template>

	<div class="list-group">

		<router-link :to="{ name : 'edit.report', params : { type : 'user' } }" class="list-group-item list-group-item-action no-border">
			<a @click="SET_REPORT({ obj : user, type : 'user' })"
				<div class="media">
					
					<div class="media-left align-self-center">
						<i class="fa fa-ban app-fa"></i>
					</div>
					<div class="media-body align-self-center pl-2">
						
						<span class="app-small-text">Report</span>

					</div>

				</div>
			</a>
		</router-link>

		<div class="list-group-item no-border">
			
			<BlockButton :user="user" :classes="'btn-block input-block-level btn-sm'"></BlockButton>

		</div>

	</div>
	
</template>

<script type="text/javascript">

	import BlockButton from '../userBuilders/BlockButton'
	import { mapMutations } from 'vuex'
	
	export default {

		name : "ProfileOptions",
		props : ['user'],
		components : {

			BlockButton

		},
		methods : {
			...mapMutations("report", ['SET_REPORT'])
		}

	};

</script>

<style type="text/css" scoped>

.list-group-item,
.list-group{
	border: 0;
}
	
</style>