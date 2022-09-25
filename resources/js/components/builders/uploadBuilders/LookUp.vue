<template>

	<div class="look-up-wrap" v-show="show">
		
		<div class="media p-2">
			<div class="media-body align-self-center"></div>
			<div class="media-right align-self-center">
				<a @click="show = !show">   
          <i class="fa fa-times app-fa"></i>
        </a>
			</div>
		</div>

		<look-up-skeleton v-if="search.loading"></look-up-skeleton>
		<div class="list-group no-border" v-else>

			<a class="list-group-item-action list-group-item" v-for="(user, i) in users.list" :key="i"  @click="formatter(user.getBasic().handle)">
				
				<div class="media">
					<Picture :user="user" :height="30" :width="30"></Picture>
					<div class="media-body align-self-center pl-2">
						<user-name :user="user"></user-name>
					</div>
				</div>

			</a>

		</div>

	</div>
	
</template>

<script type="text/javascript">

	import { mapGetters, mapActions, mapMutations } from 'vuex'
	import LookUpSkeleton from '../skeletonBuilders/LookUpSkeleton'
	
	export default {

		name  : "LookUp",
		data  : () => ({
			matches : [], // Hold @mentions that match the Regex Exp
			pattern : /@+([a-zA-Z0-9_]+)/g, // Regex Exp For Identifying @mentions
			show : false
		}),
		components : {
			LookUpSkeleton
		}, // Raw String To extract @mentions from
		computed : {
			...mapGetters('find', ['search']),
			...mapGetters('files', ['Text']),

			users : function(){
				return this.search.data.users
			},
			textToArray : function(){
				return this.Text.toString().split(" ") || [] // Turn Raw String To Array
			},
			lastIndex : function(){
				return this.textToArray.length > 0 ? this.textToArray.length - 1 : 0
			},
			matchLastItem : function(){
				return this.matches[this.matches.length - 1] || ''
			}
		},
		methods : {
		...mapActions('find', ['getSearch']),
		...mapMutations('files', ['setText']),
		/*
			Take raw string, extract "@mentions" of users to search for them while the user is still typing...
		*/
		toMention : function(){

				if(this.textToArray.length == 0 || this.Text.length == 0) return // Exit on empty String

				if(this.pattern.test(this.Text)){ // Test for matches, return TRUE on correct matches

					this.matches = this.Text.match(this.pattern) // returns an array of matches
					let currentMention = this.textToArray[this.lastIndex].toString() || ''

					if(currentMention.substring(0, 1) === '@' && currentMention.length > 1){

						// If Matches Length Is Higher Means A New Match Is Found,
		  		  // Always use the last array element as search to always search the current typed mention
		  		  // Show Mentions Wrapper

		  		  console.log(currentMention)
		  		  console.log(this.matchLastItem)

		  		  this.show = true // Show The Popup for user to select
		  		  this.getSearch(this.matchLastItem)
					
					}else{
						this.show = false // Dont show the popup
					} // 

				} // end of Test

			},
			formatter : function(handle){

				// Since the string is an array form, the mention we want to replace is the last Index...we just have to override the last Index string with the correct-searched-for handle
				this.textToArray[this.lastIndex] = this.textToArray[this.lastIndex].replace(this.matchLastItem, (x, y) => {

					return `@${handle}` // replace the last index with this handle

				})

				this.setText(`${this.textToArray.join(" ")} `) // format the array back to String

			}
		},
		watch : {
			Text : function(text){
				if(text && text.length > 0) this.toMention() // only look for mentions if the string is not empty
			},
			'users.found' : function(bool){

				this.show = bool

			}
		}

	};

</script>

<style type="text/css" scoped>

	.look-up-wrap{
		margin: auto;
	  width: 80%;
		z-index: 99999 !important;
		background-color: #fff;
		min-height: 100px;
		border : .04em solid rgba(211, 211, 211, .200);
		box-shadow: .5px .5px rgba(211, 211, 211, .175);
	}

	.list-group-item{
		border: 0;
		border-bottom: .04em solid rgba(211, 211, 211, .100);
	}
	
</style>