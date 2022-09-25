<!-- <template>
    <span class="container text-container" style="text-align:left" v-if="text != ''">
      <span class="app-post-text">{{ text }}</span>
    </span>
</template> -->

<script>

  import globs from '../../../tunepik/attack.js'

  import {mapGetters} from 'vuex'

    export default {

        name    : "TextBodyBuilder",
        data    : () => ({
          screen : globs.app.isMobile,
        }), 
        props : ['text'],
        template : '<component v-bind:is="transform"></component>',
        computed : {
          transform(){
            return {
              template : this.textBundler(this.text),
              computed : {
                ...mapGetters('tunepik', ['theme']),
                color : function(){
                  if(this.theme.icons.type === 'default') return this.theme.colors.blue
                  else if(this.theme.icons.type === 'danger') return this.theme.colors.red
                  else return (this.theme.icons.color === this.theme.colors.light ? this.theme.colors.blue : this.theme.icons.color)
                }
              }
            }
          }
        },
        methods : {
          mentions: function(str) {
            return str.replace(/@([\w]+)/g,'<span class="app-highlighted-text"><router-link style="font-weight: bold !important;font-weight: 10.5pt !important;" :style="{ color : color }" class="app-highlighted-text" to="/$1">@$1</router-link></span>')
          },
          hashtags : function(str){
            return str.replace(/#([\w]+)/g,'<span class="app-highlighted-text"><router-link style="font-weight: bold !important;font-weight: 10.5pt !important;" :style="{ color : color }" class="app-highlighted-text" to="/$1">#$1</router-link></span>')
          },
          textBundler(text){

            let str = `<span class="container text-container"><span class="app-post-text">${this.hashtags(this.mentions(text))}</span></span>`
            return str

          }
        }

    };
</script>

<style scoped>
  
  .text-container{
    display: block;
  }

  .app-highlighted-text{
    font-weight: bold !important;
    color: skyblue !important;
    font-weight: 10.5pt !important;
  }

</style>
