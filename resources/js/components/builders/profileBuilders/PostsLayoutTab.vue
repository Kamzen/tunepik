<template>

		<div class="app-profile-nav mt-1">
		 	<div class="action-profile-nav pb-1">
		 	 	  <center>
		 	 	  	<span class="app-feed-context-text app-grey-text-lg">{{ headerText }}</span>
		 	 	  </center>
		 	 <table class="app-profile-nav-table">
		 	 	 <tr>
		 	 	 	 <td class="app-tab app-profile-tab list-tab">
		 	 	 	 	 <center>
		 	 	 	 	 	 <router-link :to="{ name : tab.list }" class="list-btn user-nav-btn">
		 	 	 	 	 	 	 <Icon :icon="'list'" :width="20" :height="20" :color="underline.list"></Icon>
		 	 	 	 	 	 	</router-link>
		 	 	 	 	 </center>
		 	 	 	 </td>
		 	 	 	 <td class="app-tab app-profile-tab grid-tab">
		 	 	 	 	 <center>
		 	 	 	 	 	<router-link :to="{ name : tab.grid, params : { type : 'all' } }" class="grid-btn user-nav-btn">
		 	 	 	 	 		<Icon :icon="'grid'" :width="20" :height="20" :color="underline.grid"></Icon>
		 	 	 	 	 	</router-link>
		 	 	 	 	 </center>
		 	 	 	 </td>
		 	 	 	 <td class="app-tab app-profile-tab saved-tab">
		 	 	 	 	 <center>
		 	 	 	 	 	<router-link :to="{ name : tab.liked }" class="saved-btn user-nav-btn">
		 	 	 	 	 		<Icon :icon="'heart'" :width="20" :height="20" :color="underline.liked"></Icon>
		 	 	 	 	 	</router-link>
		 	 	 	 	 </center>
		 	 	 	 </td>
		 	 	 </tr>
		 	 </table>
		 	</div>
		 	<center></center>
		 </div>

</template>

<script>

		import { mapGetters, mapActions, mapMutations } from 'vuex'
		import globs from '../../../tunepik/attack.js'

		export default {

			  name 	:    "PostsLayoutTab",
			  data  : () => ({
			  	underline : {
			  		list : '',
			  		grid : '',
			  		liked: ''
			  	},
			  	screen : globs.app.isMobile
			  }),
			  props :   ['headerText', 'user'],
		  	computed : {
		  		...mapGetters('tunepik', ['theme']),
		  		username : function(){
		  			return this.$route.params.username;
		  		},
		  		tab : function(){
		  			return {
		  				list 	: 'profile',
		  				grid 	: 'grid',
		  				liked : 'liked'
		  			}
		  		},
		  		getTag : async function(){
		  			console.log(this)
	          const tags = await this.$el.children
	          return tags.length > 0 ? tags[tags.length - 1] : 0
	           // returns the last center tag
	        },
	        params : async function(){
	        	return {
	        		callback : (isVisible) => {

	        			this.SIDE_PROFILE({ show : !isVisible }) // If is Visible, the do not show it!

	        		},
	        		element : await this.getTag,
	        		inView  : true
	        	}
	        }
		  	},
		  	methods : {
		  		...mapActions("tunepik", ['scroller']),
		  		...mapMutations("profile", ['SIDE_PROFILE']),
		  		underliner : function(tab){

		  			let tabs = ['list', 'grid', 'liked']

		  			tabs.forEach((item, i) => {
		  				if(item === tab){
		  					this.underline[item] = this.theme.icons.type === 'default' ? this.theme.colors.blue : this.theme.icons.color
		  				}else{
		  					this.underline[item] = this.theme.type === 'theme-dark' || this.theme.type === 'theme-dim' ? (this.theme.icons.type === 'default' ? this.theme.colors.light : this.theme.colors.lightgrey) : this.theme.colors.darkgrey
		  				}
		  			})
		  		}
		  	},
		  	created : function(){
		  		this.underliner(this.headerText.toString())
		  	},
		  	mounted : async function(){
		  		if(!this.screen) this.scroller(await this.params)
		  	},
		  	watch : {

		  		'$route.path' : function(currentPath){

			  			switch (currentPath) {
			  				case `/${this.user.getBasic().handle}/`:

			  						this.underliner('list')

			  					break;

			  				case `/${this.user.getBasic().handle}/grid/all` :

			  						this.underliner('grid')

			  					break;

			  				case `/${this.user.getBasic().handle}/liked` :

			  						this.underliner('liked')

			  				default:
			  					// statements_def
			  					break;
			  			}

			  		}
		  	}

		};

</script>


<style scoped>

	@media only screen and (min-width: 700px){

  	.action-profile-nav{
  		/*border: .05em solid rgba(211, 211, 211, .5);*/
  	}

  	.col-lg-4{

  	}

  	.row{
  		padding-right :15px;
  	}

  }

   @media only screen and (max-width: 700px){

  	.action-profile-nav{
  		border: 0;
  		border-bottom: .04em solid rgba(211, 211, 211, .175);
  	}

  	.action-nav-icon{

  		width: 20px;
  		height: 20px;

  	}

  }

</style>
