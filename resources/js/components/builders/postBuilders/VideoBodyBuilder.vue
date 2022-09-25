<template>

	<div class="app-image-body main-wrapper">

    <a class="media-anchor" >

     <!--  <div class="embed-responsive embed-responsive-1by1"> -->

        <!-- <ImageBodyBuilder :post="post" v-show="!show" :thumb="true"></ImageBodyBuilder> -->

      	<video class="app-media app-video main-wrapper" ref="vid">

      		<source :src="post.getPost().url" />

      	</video>

        <div class="controls">
          
          <a @click="play()" v-show="played == false">
            
            <i class="fa fa-play app-fa" ></i>

          </a>
          <a @click="play()" v-show="played == true">

            <i class="fa fa-pause app-fa"></i>

          </a>

        </div>

      <!-- </div> -->

    </a>

  </div>

</template>

<script>

  import globs from '../../../tunepik/attack.js'
  import ImageBodyBuilder from "./ImageBodyBuilder";

    export default {

        name    : "VideoBodyBuilder",
        data    : () => {

          return {

            screen : globs.app.isMobile,
            show   : false,
            played : false,

          }

        },
        components : {
          ImageBodyBuilder
        },
        props : ['post'],
      computed : {

          video : function() {
            return this.$el.getElementsByTagName('video')[0]
          }

      },
      methods : {

          play : function () {

            this.show = true

            this.video.paused ? this.video.play() : this.video.pause()

            this.played = this.video.paused ? false : true

          }

      }

    };
</script>

<style scoped>

  .controls{
    position: relative;
    top: -25px;
    padding-left: 10px;
    height: 0px;
  }

</style>
