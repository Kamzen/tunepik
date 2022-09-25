<template>

  <div class="wrapper">
    <Navigation v-if="screen">

      <div class="media-body align-self-center">

        <span class="app-max-text">
          {{ header }}
        </span>

      </div>
      <div class="media-right"></div>

    </Navigation>
    <div class="visible-xs space-large"></div>
    <div class="visible-xs space-large"></div>
    <Reporter></Reporter>

  </div>

</template>

<script>

    import Navigation from "../../components/mobile/root/Navigation"
    import globs from "../../tunepik/attack"
    import Reporter from "../../components/builders/bundlers/Reporter"
    import { mapGetters, mapMutations } from 'vuex'

    export default {
        name: "report",
        data : () => ({
           screen : globs.app.isMobile,
        }),
        components: {
          Navigation,
          Reporter
        },
        computed : {
          ...mapGetters("report", ['reporter']),
          route : function(){
            return this.$route.params
          },
          header : function(){

            if(this.reporter.type == ''){
              this.SET_REPORT({obj : null, type : this.route.type})
            }

            console.log(this.route.type)
            console.log(this.reporter)
            console.log(this.reporter.type)
            switch (this.reporter.type) {
              case 'post':
                return `Report Post`
                break;
              case 'comment':
                return 'Report Comment'
                break;
              case 'user':
                return `Report User`
                break;
              case 'bug':
                return `Report A Bug`
                break;
              default:
                return `Report`
                break;
            }
          }
        },
        methods : {
          ...mapMutations("report", ['SET_REPORT']),
        },

    };
</script>

<style scoped>

  @media only screen and (max-width: 700px){

      .wrapper{
        z-index: 1031 !important;
        position: fixed;
        top : 0;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 100%;
        overflow-y: auto;

      }

      .cover-img{

        width: 100%;
        height: 200px;

      }

    }

</style>
