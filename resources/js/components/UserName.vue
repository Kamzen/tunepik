<template>

	<span>
		
		<span class="app-bolder-text">{{ trim(user.getBasic().name, limit) }}</span><verified :user="user"></verified>
	   <span class="profile-user-handle app-grey-text-sm" style="display: block;line-height: 1;">
	      @{{ user.getBasic().handle }}
	   </span>

	</span>
	
</template>

<script type="text/javascript">

	 import globs from '../tunepik/attack.js'

	export default {

		name : 'UserName',
		data : () => ({
			trim : globs.trim
		}),
		props : ['user', 'limit'],
		computed : {

			lim : function(){

				return this.limit ? this.limit : 30

			}

		}

	};
	
</script>

<style type="text/css" scoped></style>