<template>

	<div class="wrapper">

		<Navigation class="navbar fixed-top">

			<div class="media-body align-self-center"> <!-- ml-1 pl-2 pr-1 -->
				
				<div class="search-wrapper"> <!-- grey-matter -->

					<div class="media full-width">
						<div class="media-left pl-1 pt-1 pb-1 align-self-center">

							<Icon :icon="'search'" class="icon-search" :width="18" :height="18" :color="theme.icons.color"></Icon>

						</div>

						<div class="media-body full-width align-self-center">
							<form @submit.prevent="redirect()">
								<input type="search" v-on:keyup="query = $event.target.value" name="search" class="xs-search app-search full-width" placeholder="search tunepik..." v-model="query" />
							</form>
						</div>

					</div>

				</div>

				</div>
				<div class="media-right align-self-center ml-2 pb-1">
					
					<a class="cancel" @click="clear()" v-show="query != ''">
						
						<span class="app-small-post">
							cancel
						</span>

					</a>
					<router-link :to="{ name : 'profile', params : { username : model.getBasic().handle } }" v-show="query == ''">
						<a @click="SET_PROFILE(model)">
							<Picture :height="30" :width="30" :user="model"></Picture>
						</a>
					</router-link>

				</div>

		</Navigation>

		<div class="space-large"></div>
		<div class="space-medium"></div>

		<div class="search-results">
				
				<SearchView :q="query"></SearchView>

		</div>

		<div class="search-extend" v-show="query === ''">
			
			<MobileSuggestions></MobileSuggestions>

		</div> 

		<div class="space-large"></div>
		<div class="space-medium"></div>
		<div class="space-large"></div>
		<div class="space-medium"></div>

	</div>
	
</template>

<script>

	import MobileSuggestions from '../components/mobile/root/MobileSuggestions'
	import SearchView from '../components/builders/SearchView'
	import Navigation from '../components/mobile/root/Navigation'
	import { mapGetters, mapMutations } from 'vuex'

  export default {

  	name : "Search",
  	scrollToTop : false,
  	data : function(){

  		return {

  			query : ''

  		}

  	},
  	components : {

  		MobileSuggestions,
  		SearchView,
  		Navigation

  	},
  	methods : {

  		...mapMutations('profile', ['SET_PROFILE']),
  		clear : function(){

  			this.query = ''

  		},
  		redirect : function(){

  			if(this.query != '') this.$router.push({ name : 'results', params : { term : this.query } })

  		}

  	},
  	computed : {

  		...mapGetters('tunepik', ['theme']),
  		...mapGetters('auth', ['model']),

  	}

  };
	
</script>

<style scoped>

   
	.search-wrapper{
		/*border : .04em solid rgba(211, 211, 211, .4);*/
		/*border-radius: 20px;*/
		position: relative;
		height: 35px;
		top: -2px;
	}

	.xs-search{
		width: 100%;
    border: none;
    font-size: 11pt;
    float: left;
    /*color: #63717f;*/
    padding-left: 4px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 2px;
    outline : 0;
    background-color: transparent;
	}
	
</style>