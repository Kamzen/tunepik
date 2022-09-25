<template>

	<div class="wrappper">
		
		<div :class="[text.getActivity().me ? right : left]">
										
			<div class="message-wrap">
				
				<div class="message-image message-block">
					
					<Picture :height="40" :width="40" :user="text" v-if="!text.getActivity().me"></Picture>

				</div>

				<div class="message-text message-block ml-2">
					
					<MediaBodySwitch class="message-block" :post="text" v-if="text.getMessage().type != 'text' || text.getMessage().type == ''"></MediaBodySwitch>

					<div class="app-message-bubble pl-1 message-block grey-matter">
						
						<span class="app-post-text">
							{{ text.getMessage().message }}
						</span>

					</div>
					<br />
					<span class="app-grey-text-sm ml-1">
						{{ text.getMessage().now }}
					</span>

				</div>

				<div class="message-block message-image">
					
					<Picture :height="40" :width="40" :user="text" v-if="text.getActivity().me"></Picture>

				</div>

			</div>

		</div>

	</div>
	
</template>

<script type="text/javascript">

	import MediaBodySwitch from '../postBuilders/MediaBodySwitch'
	
	export default {

		name 		: "TextBubble",
		data 		: function(){
			return {
				left    : 'app-left-message app-message',
				right   : 'app-right-message app-message',
			}
		},
		props 	: ['text'],
		components : {

			MediaBodySwitch

		}

	};
	
</script>

<style type="text/css" scoped>

	.message-block{
		display: inline-block;
	}

	.app-message-bubble{
		width: auto;
		max-width: 90%;
		padding: 10px;
		border-radius: 10px;
	}
	
</style>