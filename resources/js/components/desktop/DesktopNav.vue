<template>
       
	<div class="wrapper">
		
		<div class="list-group">
			
			<router-link v-for="(item, i) in menuItems" :key="i" :to="{ name : item.link}" class="list-group-item list-group-item-action no-border">
				
				<a @click="colorCurrent(item.name)">
					<div class="media">
						
						<div class="media-left align-self-center">
							<Icon :icon="item.icon" :width="iconSize" :height="iconSize" :color="itemColors[item.name]"></Icon>
						</div>
						<div class="align-self-center media-body pl-2">
							<span class="app-max-text" :style="{color : itemColors[item.name]}">
								{{ item.name }}
							</span>
						</div>

					</div>
				</a>

			</router-link>

		</div>

	</div>

</template>

<script>
  import {mapGetters, mapActions} from 'vuex';

    export default {
        name: "DesktopNav",
        data : () => ({
        	iconSize : 28,
            itemColors : {
                Home : '',
                Messages : '',
                Notifications : ''
            }
        }),
        methods : {
            ...mapActions("tunepik", ['getIconColor', 'getTextColor'])
        },
        computed : {

        	...mapGetters("tunepik", ['theme']),
        	menuItems(){
        		return [
        			{
        				name : 'Home',
        				icon : 'home',
        				link : 'home',
        			},
        			{
        				name : 'Messages',
        				icon : 'messages',
        				link : 'chats',
        			},
        			{
        				name : 'Notifications',
        				icon : 'notifications',
        				link : 'notifications'
        			}
        		]
        	},
            colorCurrent(current){
            
                this.menuItems.forEach(item => {

                    /*this.itemColors[item] = current === item.name ? this.getIconColor() : this.getTextColor()*/

                    if(current === item.name){

                        this.itemColors[item] = this.theme.icons.type === 'default' ? this.theme.colors.blue : this.theme.icons.color

                    }else{

                        this.itemColors[item] = this.theme.type === 'theme-dark' || this.theme.type === 'theme-dim' ? (this.theme.icons.type === 'default' ? this.theme.colors.light : this.theme.colors.lightgrey) : this.theme.colors.darkgrey

                    }

                })

            }

        }
        
    };
</script>

<style scoped>


</style>