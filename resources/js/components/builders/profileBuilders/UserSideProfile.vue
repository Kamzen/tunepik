<template>

	<div class="side-profile-wrapper wrapper">
		
		<div class="user-wrap-cover"></div>

		<div class="card scroll-wrappers">
			<div class="card-header">
				<user-nav-builder :user="user"></user-nav-builder>
			</div>
			<div class="card-body no-border">
	       <user-info-builder :user="user"></user-info-builder>

	       <center>
	       	<user-follows-builder :user="user"></user-follows-builder>
	       </center>

	       <div class="space-small"></div>
	       <center>
	         <user-stats-builder :user="user"></user-stats-builder>
	       </center>
	    </div>
		</div>

	</div>

	
</template>

<script type="text/javascript">

	 import UserInfoBuilder from './UserInfoBuilder'
	 import UserFollowsBuilder from './UserFollowsBuilder'
	 import UserExtendedView from './UserExtendedView'
	 import UserStatsBuilder from './UserStatsBuilder'
	 import UserNavBuilder from './UserNavBuilder'
	
	export default {
		name : 'UserSideProfile',
		props : ['user'],
		components : {
			UserInfoBuilder,
			UserFollowsBuilder,
			UserExtendedView,
			UserStatsBuilder,
			UserNavBuilder
		}
	};

</script>

<style type="text/css" scoped>
	
	.user-wrap-cover{
    border : .04em solid rgba(211, 211, 211, .100);
    height : 150px;
    background-color: #fff;
  }

  .card-wrapper{
  	border: .04em solid rgba(211, 211, 211, .100);
  }

  .scroll-wrapper{
    width : 99%;
    position : relative;
    top : -40px;
    left : 2px;
  }

  .side-profile-wrapper{
    position: fixed;
    bottom: 200px;
    top: 80px;
    right: 3%;
    left: 71%;
    border: .04em solid rgba(211, 211, 211, .175);
  }

</style>