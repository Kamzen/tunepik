<template>

  <div class="app-react-body container-fluid">

    <div class="media">
      
      <!-- Wrapper For React Icons -->
      <div class="react-round">
        
        <!-- For Liking -->
        <a href="#" class="p-1">
          
          <span class="like-icon-wrapper">
              
              <svg-vue icon="heartEmpty" class="app-icon react-icon"></svg-vue>

          </span>
          
          <!-- <span class="app-bold-text pt-1" v-if="post.getStats().likeCount > 0">{{ post.getStats().likeCount }}</span> -->

        </a>

        <!-- For Commenting -->
        <router-link :to="{ name : 'comment', params : { username : post.getBasic().handle, id : post.getPost().id, type : post.getPost().type } }" >
          
          <span class="comment-icon-wrapper p-1">
            
            <svg-vue icon="comment" class="app-icon react-icon"></svg-vue>

          </span>

        </router-link>

        <!-- For Sharing -->
        <a v-on:click="toggleShareP()" class="p-1">
          
          <span class="share-icon-wrapper">
            
             <svg-vue icon="share" class="app-icon react-icon"></svg-vue>

          </span>

        </a>

      </div>

      <!-- Wrapper Prolly For Date, If Not Empty -->
      <div class="media-body">

      </div>

      <!-- Wrapper For External Sharing -->
      <div class="react-round">
        
        <a v-on:click="toggleShareX()" class="p-1">
          
          <span class="x-share-icon-wrapper">
            
            <svg-vue icon="xshare" class="app-icon react-icon"></svg-vue>

          </span>

        </a>

      </div>

    </div>

    <div class="counter-wrapper">
    
        <span v-if="post.getStats().likeCount" class="pl-2">

          <span class="app-bolder-text">{{ post.getStats().likeCount }}</span>
          <span class="app-grey-text-lg" v-if="post.getStats().likeCount > 1"> likes</span>
          <span class="app-grey-text-lg" v-else-if="post.getStats().likeCount == 1"> liked</span>

        </span>

        <span v-if="post.getStats.comCount > 0">

            <span class="app-bolder-text ml-2">{{ post.getStats().comCount }}</span>
            <span class="app-grey-text-lg" v-if="post.getStats.comCount > 1"> comments</span>
            <span class="app-grey-text-lg" v-else-if="post.getStats.comCount == 1"> commented</span>

        </span>

     </div>


     <!-- SHARE POST EXTERNALLY POP UP -->
     <PopUpWindow :headerText="shareXHeader" :show="showShareX">

      <ShareXPop :post="post"></ShareXPop>

     </PopUpWindow>


     <!-- SHARE POST INTERNALLY POP UP -->
     <PopUpWindow :headerText="sharePHeader" :show="showShareP">
       
       <SharePostPop :post="post"></SharePostPop>

     </PopUpWindow>



  </div>
       
</template>

<script>

  import globs from '../../../tunepik/attack.js'
  import PopUpWindow from '../popupBuilders/PopUpWindow'
  import ShareXPop from '../popupBuilders/ShareXPop'
  import SharePostPop from '../popupBuilders/SharePostPop'

    export default {

        name        : "ReactionBodyBuilder",
        components  : {

            PopUpWindow,
            ShareXPop,
            SharePostPop

        },
        data        : () => {

          return {

            screen      : globs.app.isMobile,
            shareXHeader : 'Share Post',
            showShareX   : false,
            showShareP   : false,

          }

        }, 
        props       : ['post'],
        methods     : {

            toggleShareX  : function(){

              this.showShareX = !this.showShareX;

            },
            toggleShareP  : function(){

              this.showShareP = !this.showShareP;

            }

        },
        computed    : {

            sharePHeader : function(){

              return `Share @${this.post.getBasic().handle} Post`;

            },

        }


    };
</script>

<style scoped>

  .react-round{

    border-radius: 20px;
    padding: 8px;
    -webkit-box-shadow: 0 .5px 1px rgba(0, 0, 0, .175);
    box-shadow: 0 .5px 1px rgba(0, 0, 0, .175);

  }

  .react-count-wrapper{

    border: .05em solid rgba(211, 211, 211, .175)

  }

  .app-react-body{



  }

  .react-icon{

    width : 20px;
    height : 20px;

  }

</style>
