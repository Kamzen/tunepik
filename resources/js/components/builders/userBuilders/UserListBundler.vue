<template>

	<div class="root-level-wrap">

		<!-- Users List Not Empty -->
		<template v-if="users.length > 0">

			<!-- Root Level Wrapper -->
			
			<CardGridBundler :users="users" v-if="grid"></CardGridBundler>
			<div class="list-group" v-else>
				
				<!-- For Loop! -->
				<template v-for="(user, index) in users">
				
						<UserRowBuilder :user="user" ></UserRowBuilder>

				</template>

				<div class="app-loader-wrap">
					
					<center>
						<div class="app-loader"></div>
					</center>

				</div>

			</div>

		</template>

		<!-- List Empty -->

		<template v-else >
			
			<div class="app-deleted-post grey-matter">
				
				<center>
					<span class="app-small-text">
						{{ message }}
					</span>
				</center>

			</div>

		</template>

	</div>
       
</template>

<script>

  import globs from '../../../tunepik/attack.js'
  import UserRowBuilder from './UserRowBuilder'
  import CardGridBundler from './CardGridBundler'
  import { mapGetters, mapActions } from 'vuex'

    export default {

        name       : "UserListBundler",
        data       : () => ({

        	appLoader  : false,
        	screen 	 : globs.app.isMobile,
            loaderVisible : false

        }),
        components : {

        	UserRowBuilder,
        	CardGridBundler

        },
        props 		: ['users', 'message', 'showGrid'],
        methods   : {
        	...mapActions('tunepik', ['observer', 'scroller']),
            ...mapActions('lists', ['getPostLists']),
            ...mapActions('profile', ['getFollowsUsers']),
        	makeInfiniteRequest : function(){

        		let url = '/api/'
        		switch (this.$router.currentRoute.name) {
        			
        			case 'list' :

                        this.getPostLists({url : `${url}react/view/${this.$route.params.type}`, lastId : this.getLastId})

        				break;

        			case 'follows' :

                        this.getFollowsUsers({url : `${url}follow/${this.$route.params.type}/${this.profile.model.getBasic().id}/`})

        			  break;

        			case 'blocked' :


        				break;
        			default:
        				 console.log(this.$router.currentRoute.name)
        				break;
        		}

        	}

        },
        computed : {
            ...mapGetters('profile', ['profile']),
        	grid : function(){
        		return this.showGrid ? this.showGrid : (this.showGrid == undefined ? true : false) 
        	},
        	getLastId : function(){
        		return this.users.length > 0 ? this.users[this.users.length - 1] : 0
        	},
        	args : async function(){

              return  {

                callback : (isVisible) => {

                    if(isVisible){

                      if(this.infite){

                        this.loaderVisible = true
                        

                        this.makeInfiniteRequest()

                        this.infite = false

                      }

                    }else{

                      this.loaderVisible = false
                      this.infite = true

                    }


                  },
                element : await this.tag,
                inView  : true

              }

            },
        	tag : async function(){

        		let tags = await this.$el.getElementsByTagName('center')
        		return tags.length > 0 ? tags[tags.length - 1] : null

        	}

        },
        mouted : function(){

        	/*this.$nextTick(() => {

        		this.observer(this.data)

        	})*/

        },
        watch : {

            users : async function(users){
                if(users) await this.scroller(await this.args)
            }

        }

    };
</script>

<style scoped>

</style>
