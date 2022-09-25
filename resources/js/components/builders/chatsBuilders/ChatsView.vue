<template>

	<div class="card-body">
		<div v-if="chat.loading">
				
			<div class="space-large visible-xs"></div>
			<div class="space-medium visible-xs"></div>
			<chats-skeleton></chats-skeleton>

		</div>
		<div v-else>
			 	
		 	<div class="space-large visible-xs"></div>
		 	<div class="space-small visible-xs"></div>

		 	<div class="space-large visible-xs" v-if="chat.error"></div>
		 	<div class="pr-2 pl-2 app-deleted-post grey-matter" v-if="chat.error">
		 		
		 		<center>
		 			<span class="app-small-text">
		 				{{ chat.message }}
		 			</span>
		 		</center>

		 	</div>

		 	<slot></slot>

		 	<div class="list-group" v-if="!chat.error">

		 		<div class="list-group-item p-3 pt-4 list-group-item-action" v-for="(message, i) in chat.chats" :key="i">
		 			<chat-item :message="message"></chat-item>
		 		</div>

			</div>
		</div>

	</div>
	
</template>

<script type="text/javascript">
	
	import { mapActions, mapGetters, mapMutations } from 'vuex'
	import ChatsSkeleton from '../skeletonBuilders/ChatsSkeleton'
	import ChatItem from './ChatItem'
	
	export default{
		name : "ChatsView",
		components : {
			ChatsSkeleton,
			ChatItem
		},
		methods     : {
		 	...mapActions("messages", ['getChats']),
		 	...mapMutations("messages", ['INSERT_CHAT']),
		 	chatsChannel : function(){
		 		window.Echo
					.private(`chats-event.${this.model.getBasic().id}`)
					.listen('incoming-chats', chats => {
						console.log(chats)
						this.INSERT_CHAT(chats)
				})
		 	}
		},
		computed : {
			...mapGetters("messages", ['chat']),
			...mapGetters("auth", ['model']),
		},
		mounted      : function(){
	 	 this.$nextTick(function(){

	 	 	 if(this.chat.chats.length == 0) this.getChats()

	 	 	 this.chatsChannel()

	 	 });
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