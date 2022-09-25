<template>

		<div class="wrapper">
			
			<center>

        <div class="media">
          
          <div class="media-left ml-2 align-self-center">
            
            <div v-show="makeIcon">
              
              <a @click="playpause(timeView)" >

                <span >
                  <i class="fa fa-pause app-fa"></i>
                </span>
                
              </a>

            </div>

            <div v-show="!makeIcon">

              <a @click="playpause(timeView)" >

                <span >
                  <i class="fa fa-play app-fa"></i>
                </span>

              </a>

            </div>

            
            

            <div class="media-info-body mt-1">
              <div class="media-text info-views">
                {{ timeView }}
              </div>
            </div> 

          </div>

          <div class="media-body pr-2">

            <div class="wave-surf" :id="postId" ref="wave"></div>
            
          </div>

        </div>

			</center>
			<!-- <div class="media-info-body">
				<div class="media-text info-views">
					{{ timeView }}
				</div>
			</div> -->

		</div>
       
</template>

<script>

  import globs from '../../../tunepik/attack.js'
  import WaveSurfer from 'wavesurfer.js'
  import { mapGetters } from 'vuex'

    export default {

        name    		: "AudioBodyBuilder",
        components	: {

        },
        data    		: () => ({
          screen         : globs.app.isMobile,
          isPlayerReady  : false,
          timeView       : '00:00',
          playing        : false,

        }) ,
        props    : ['url', 'id'],
        computed : {

          ...mapGetters('tunepik', ['theme']),
        	player : function(){

        		return WaveSurfer.create(this.options);

        	},
          progressColor : function(){

            if(this.theme.icons.type == 'default'){

              return this.theme.type == 'theme-dark' || this.theme.type == 'theme-dim' ? this.theme.colors.light : this.theme.colors.yellow

            }else{

              return this.theme.icons.color

            }

          },
          options : function(){

              return {

                container : this.$refs.wave/*`#${this.postId}`*/,
                waveColor : this.theme.colors.blue,
                progressColor : this.progressColor,
                barWidth: 2,
                barHeight: 30,
                barRadius: 3,
                barGap: 2,
                height: 40,
                interact: true

              }

            },
            postId : function(){

                return `surfer-${this.id}`;

            },
            makeIcon : function(){
              return this.playing
            }

        },
        methods  : {

        	isReady   : function(time){


        		this.player.on('ready', () => {

        			globs.timer.time({ view : time, currentTime : this.player.getDuration() });

        			this.isPlayerReady = true;

        		});

        	},
        	playpause : function(time){

        		if(this.isPlayerReady){

        			this.player.playPause();

              this.playing = this.player.isPlaying() ? true : false

              console.log(this.playing)

        			this.player.on('audioprocess', () => {

        				// globs.timer.time({ view : time, currentTime : this.player.getCurrentTime() });

        			});


        		}

        	},
          

        },
        watch : {

          playing : function(nval, oval){

            console.log(nval, oval, this.makeIcon)

          }

        },
        mounted  : function(){

          console.log(this.player)

            this.player.load(this.url);

        	this.$nextTick(function(){

                this.isReady(this.timeView); // Init The Player To Ready Status

            });

        }

    };
</script>

<style scoped>

	.wrapper-audio{

		border: 0;
		width: 100%;

	}

  .app-fa{
   /* width: 28px;
    height: 28px;*/
  }

</style>
