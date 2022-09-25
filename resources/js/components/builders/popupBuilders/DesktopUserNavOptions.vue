<template>

	<div class="list-group wrapper">
		<router-link class="list-group-item list-group-item-action no-pad" :to="{ name : 'profile', params : { username : user.getBasic().handle } }">
			<div class="media">
				<div class="media-body align-self-center">
					<span class="app-post-text">Profile</span>
				</div>
			    <div class="media-right align-self-center">
			    	<Picture :user="user" :height="15" :width="15"></Picture>
			    </div>
			</div>
		</router-link>
		<router-link class="list-group-item list-group-item-action no-pad" :to="{ name : 'edit.account', params : { username : user.getBasic().handle } }">
			<div class="media">
				<div class="media-body align-self-center">
					<span class="app-post-text">Settings</span>
				</div>
			    <div class="media-right align-self-center">
			    	<span class="icon-wrapper">
						<i class="fa fa-chevron-right app-fa"></i>
					</span>
			    </div>
			</div>
		</router-link>

	</div>
	
</template>

<script type="text/javascript">
	
	export default {
		name : "DesktopUserNavOptions",
		data : () => ({

		}),
		props : ['user'],
	};

</script>

<style type="text/css" scoped>
	.list-group-item{
		padding-top: 8px;
		padding-bottom: 8px;
		padding-right: 8px;
		padding-left: 8px;
	}
</style>