<template>

  <div class="app-react-body container-fluid">


    <div class="animate-hearts-body" v-show="animateBody">

      <center>
        <span class="app-post-text">
          <Icon :icon="'heart'" :height="38" :width="38" :color="'red'"></Icon>
          &nbsp;&nbsp;+{{ post.getStats().likeCount == 0 ? 1 : post.getStats().likeCount + 1  }}
        </span>
      </center>

    </div>

    <div class="media">

      <!-- Wrapper For React Icons -->
      <div class="react-round" :style="bxShadow">

        <!-- For Liking -->


          <span class="like-icon-wrapper">

              <!-- <svg-vue icon="heartEmpty" class="app-icon react-icon"></svg-vue> -->

              <a @click="like()" class="p-1">

                <Icon :icon="'heart'" :height="iconSize" :width="iconSize" :color="'red'" v-if="post.getStats().isLiked"></Icon>
                <Icon :icon="'heartEmpty'" :height="iconSize" :width="iconSize" v-else></Icon>

              </a>

          </span>

          <!-- <span class="app-bold-text pt-1" v-if="post.getStats().likeCount > 0">{{ post.getStats().likeCount }}</span> -->


        <!-- For Commenting -->
        <router-link :to="{ name : 'comment', params : { username : post.getBasic().handle,  type : post.getPost().type, id : post.getPost().id } }" >

          <span class="comment-icon-wrapper p-1">

            <!-- <svg-vue icon="comment" class="app-icon react-icon"></svg-vue> -->
            <a @click="MAIN_POST(post)">
              <Icon :icon="'comment'" :height="iconSize" :width="iconSize" :color='post.getStats().isCommented ? theme.themes.primary : null'></Icon>
            </a>

            <!-- <span class="app-grey-text-sm" v-if="post.getStats().comCount > 0">{{ post.getStats().comCount }}</span> -->

          </span>

        </router-link>

        <!-- For Sharing -->

          <router-link :to="{ name : 'share', params : { username : post.getBasic().handle, type : post.getPost().type, id : post.getPost().id } }" >

          <span class="share-icon-wrapper">

            <a @click="MAIN_POST(post)" class="p-1">
             <!-- <svg-vue icon="share" class="app-icon react-icon"></svg-vue> -->
             <Icon :icon="'share'" :height="iconSize" :width="iconSize" :color='post.getStats().isShared ? theme.themes.primary : null'></Icon>

            </a>

          </span>

        </router-link>

      </div>

      <!-- Wrapper Prolly For Date, If Not Empty -->
      <div class="media-body align-self-center">

        <center>
          <span class="app-grey-text">
            {{ post.getPost().now }}
          </span>
        </center>

      </div>

      <!-- Wrapper For External Sharing -->
      <div class="align-self-center">

        <a v-on:click="show = !show" class="">

          <span class="x-share-icon-wrapper">

            <!-- <svg-vue icon="xshare" class="app-icon" style="height:16px;width:16px;"></svg-vue> -->
            <Icon :icon="'xshare'" :height="16" :width="16"></Icon>

          </span>

        </a>

      </div>

    </div>

    <div class="counter-wrapper p-2">

      <div class="media" v-if="post.getStats().likeCount > 0">

        <div class="media-left align-self-end" v-if="post.getStats().likedBy != ''">

          <Picture :height="15" :width="15" :user="post" ></Picture>

        </div>
        <div class="media-body align-self-center ml-1">


          <span v-if="post.getStats().likedBy != '' && post.getStats().likeCount == 1">

          <router-link v-bind:to="{ name : 'profile', params :{ username : post.getBasic().handle } }">
            <span class="app-bold-text">
              <a @click="SET_PROFILE(post)">
                {{ post.getStats().likedBy.user ?  post.getStats().likedBy.user.getBasic().handle : '' }}
              </a>
            </span>
          </router-link>
            <span class="app-grey-text-lg">
              liked
            </span>

          </span>
          <span v-else-if="post.getStats().likedBy != '' && post.getStats().likeCount >= 2">

            <router-link v-bind:to="{ name : 'profile', params :{ username : post.getBasic().handle } }">
            <span class="app-bold-text">
              <a @click="SET_PROFILE(post)">
                {{ post.getStats().likedBy.user ?  post.getStats().likedBy.user.getBasic().handle : '' }}
              </a>
            </span>
          </router-link>
            <span class="app-grey-text-lg">
              and
            </span>
            <span class="app-bold-text">
              {{ post.getStats().likeCount - 1 }}
              <span v-if="post.getStats().likeCount == 2">
                other
              </span>
              <span v-else>
                others
              </span>

              <span class="app-grey-text-lg">
                liked
              </span>

            </span>


          </span>
          <span v-else>

            <span class="app-bolder-text">{{ post.getStats().likeCount }}</span>
            <span class="app-grey-text-lg" v-if="post.getStats().likeCount > 1"> likes</span>

          </span>

        </div>

      </div>

        <!-- <span v-if="post.getStats().comCount > 0">

            <span class="app-bolder-text ml-2">{{ post.getStats().comCount }}</span>
            <span class="app-grey-text-lg" v-if="post.getStats().comCount > 1"> comments</span>
            <span class="app-grey-text-lg" v-else-if="post.getStats().comCount == 1"> commented</span>

        </span> -->

     </div>


     <!-- SHARE POST EXTERNALLY POP UP -->
     <div class="overlay-wrap" v-show="show">

       <div class="main-wrap card no-border" v-show="show" :class="[ show ? 'fade-in' : 'fade-out']">

         <div class="media card-header no-border">

           <div class="media-left align-self-center">

             <Picture :height="35" :width="35" :user="post"></Picture>

           </div>
           <div class="media-body pl-2 align-self-center">

             <span class="app-max-text">
               Share
             </span>

           </div>
           <div class="media-right align-self-center">

              <a @click="show = !show">
                <i class="fa fa-times app-fa"></i>
              </a>

           </div>

         </div>
         <div class="card-body no-border">

           <ShareXPop :post="post"></ShareXPop>

         </div>

       </div>

     </div>

  </div>

</template>

<script>

  import { mapGetters, mapActions, mapMutations } from 'vuex'
  import globs from '../../../tunepik/attack.js'
  import PopUpWindow from '../popupBuilders/PopUpWindow'
  import ShareXPop from '../popupBuilders/ShareXPop'
  import SharePostPop from '../popupBuilders/SharePostPop'
  import PostPopUp from '../popupBuilders/PostPopUp'
  import axios from 'axios'

    export default {

        name        : "ReactionBodyBuilder",
        components  : {

            PopUpWindow,
            ShareXPop,
            SharePostPop,
            PostPopUp

        },
        data        :function() {

          return {

            screen      : globs.app.isMobile,
            shareXHeader : 'Share Post',
            animateBody : false,
            iconSize  : 23,
            show  : false,
          }

        },
        props       : ['post'],
        methods     : {

          ...mapActions('tunepik', ['toggleConfirm', 'togglePopUp']),
          ...mapMutations('tunepik', ['SNACK_BAR']),
          ...mapMutations('posts', ['MAIN_POST']),
          ...mapMutations('profile', ['SET_PROFILE']),
          reactChannel : function(){

            window.Echo
              .private(`instant-post-stats.${this.post.getPost().id}`)
              .listen('.post-reacts', reacts => {

                if(this.post.getStats().likedBy.user && this.post.getStats().likedBy.user === ''){

                  this.post.getStats().likedBy.user = new globs.model.user(reacts.liked_by.user)
                  
                }

                this.post.getStats().isLiked = reacts.liked
                this.post.getStats().likeCount = reacts.count

                this.post.getStats().comCount = reacts.comments
              })

          },
          like        : async function(){

            if(this.post.getStats().isLiked){

              this.post.getStats().likeCount -= 1

              this.post.getStats().isLiked = !this.post.getStats().isLiked

            }else {

              this.post.getStats().likeCount += 1

              this.post.getStats().isLiked = !this.post.getStats().isLiked

              if(this.post.getStats().likedBy.user == ""){

                this.post.getStats().likedBy.user = this.model

              }

              this.animateBody = !this.animateBody

              setTimeout(() => {

                this.animateBody = !this.animateBody

              }, 500)

            }

            const { data } = await axios.get(`/api/react/like/${this.post.getPost().id}?type=post`);

            if(data.error){

              this.SNACK_BAR({ isOpen : true, message : data.message, theme : 'danger' })

            }else{

              this.post.getStats().isLiked = data.liked

              this.post.getStats().likeCount = data.count

              /*this.animateBody = data.liked

              if(data.liked) setTimeout(() => {

                this.animateBody = false

              }, 500)*/

            }

          }

        },
        computed    : {

          ...mapGetters('tunepik', ['overlay', 'theme']),
          ...mapGetters('auth', ['model']),
          sharePHeader : function(){

            return `Share @${this.post.getBasic().handle} Post`;

          },
          bxShadow : function(){
            return { boxShadow : `.5px .5px .5px rgba(${this.theme.type === 'theme-light' ? '211, 211, 211' : '0, 0, 0'}, .175)`}
          }

        },
        mounted : function(){

          this.$nextTick(function () {
            this.reactChannel()
          })

        }

    };
</script>

<style scoped>

  .react-round{

    border-radius: 20px;
    padding: 8px;
    /*-webkit-box-shadow: .5px .5px .5px rgba(0, 0, 0, .175);
    box-shadow: .5px .5px .5px rgba(0, 0, 0, .175);*/

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
