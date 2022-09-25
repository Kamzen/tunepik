<template>

		<div class="wrapper card no-border">
			
			<Navigation>
				
				<div class="media-body align-self-center">
					<span class="app-max-text">
						Messages
					</span>
				</div>
				<div class="media-right align-self-center">

					<a @click="show = !show" v-show="!show">
						<i class="fa app-fa fa-paper-plane"></i>
					</a>
					<a @click="show = !show" v-show="show">
						<i class="fa app-fa fa-times"></i>
					</a>

				</div>

			</Navigation>

			<chats-view>

				<div class="list-group pt-1" v-if="show">
			 		<div class="list-group-item p-3" >
			 			<search-chat></search-chat>
			 		</div>
			 	</div>

			</chats-view>
			</div>
		</div>
	
</template>

<script type="text/javascript">

		import globs from '../../../tunepik/attack.js'
		import Navigation from '../../mobile/root/Navigation'
		import SearchChat from './SearchChat'
		import ChatsView from './ChatsView'

		export default {

			 name 			: "ChatsList",
			 scrollToTop : false,
			 data 			: () => ({
		 	  	screen : globs.app.isMobile,
		 	  	show 	 : false,
		 	  }),
			  components : {
			 	 Navigation,
			 	 SearchChat,
			 	 ChatsView
			 }

		};
	
</script>

<style type="text/css" scoped>

	.list-group-item{

		border : 0;
		/*border-bottom: .03em solid rgba(211, 211, 211, .125);*/

	}
	.card-body,
	.card{

		padding: 0;
		box-shadow: 0 0 0 0 transparent;

	}

	.fa-times{
		width: 26px;
		height: 26px;
	}
	
</style>