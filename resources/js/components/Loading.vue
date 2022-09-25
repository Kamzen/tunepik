<template>
  <div :style="{
    width: `${percent}%`,
    height: height,
    opacity: show ? 1 : 0,
    'background-color': canSuccess ? theme.icons.color : failedColor
  }" class="background-animation loader"
  />
</template>

<script>
// https://github.com/nuxt/nuxt.js/blob/master/lib/app/components/nuxt-loading.vue

import { mapGetters } from 'vuex'

export default {
  data: () => ({
    percent: 0,
    show: false,
    canSuccess: true,
    duration: 3000,
    height: '2px',
    color: '#77b6ff',
    failedColor: 'red'
  }),

  computed : {

    ...mapGetters('tunepik', ['theme']),

  },

  methods: {
    start () {
      this.show = true
      this.canSuccess = true
      if (this._timer) {
        clearInterval(this._timer)
        this.percent = 0
      }
      this._cut = 10000 / Math.floor(this.duration)
      this._timer = setInterval(() => {
        this.increase(this._cut * Math.random())
        if (this.percent > 95) {
          this.finish()
        }
      }, 100)
      return this
    },
    set (num) {
      this.show = true
      this.canSuccess = true
      this.percent = Math.floor(num)
      return this
    },
    get () {
      return Math.floor(this.percent)
    },
    increase (num) {
      this.percent = this.percent + Math.floor(num)
      return this
    },
    decrease (num) {
      this.percent = this.percent - Math.floor(num)
      return this
    },
    finish () {
      this.percent = 100
      this.hide()
      return this
    },
    pause () {
      clearInterval(this._timer)
      return this
    },
    hide () {
      clearInterval(this._timer)
      this._timer = null
      setTimeout(() => {
        this.show = false
        this.$nextTick(() => {
          setTimeout(() => {
            this.percent = 0
          }, 200)
        })
      }, 500)
      return this
    },
    fail () {
      this.canSuccess = false
      return this
    }
  }
};
</script>

<style scoped>

.progress {
  position: fixed;
  top: 0px;
  left: 0px;
  right: 0px;
  height: 2px;
  width: 0%;
  transition: width 0.2s, opacity 0.4s;
  opacity: 1;
  background-color: #efc14e;
  z-index: 999999;
}

.loader {
    left: 0;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 999999;
}
.background-animation {
    height: 4px;
    background: #5bc0de -webkit-gradient(
      linear, left top, right top, 
      from(#5bc0de),
      color-stop(#42aecf),
      color-stop(#2ba8cf),
      color-stop(#128fb5),
      to(#086480)
    );
    /*background: #27c4f5 linear-gradient(
      to right, 
      #05730a, 
      #0cf718, 
      #5ef766, 
      #b0f7b3, 
      #4a914e
    );*/
    background-size: 500%;
    -webkit-animation: 2s linear infinite barprogress,.3s fadein;
    animation: 2s linear infinite barprogress,.3s fadein;
    width: 100%;
}

@-webkit-keyframes barprogress {
    0% {
        background-position: 0% 0
    }
    to {
        background-position: 125% 0
    }
}
@keyframes barprogress {
    0% {
        background-position: 0% 0
    }
    to {
        background-position: 125% 0
    }
}

@-webkit-keyframes fadein {
    0% {
        opacity: 0
    }
    to {
        opacity: 1
    }
}

@keyframes fadein {
    0% {
        opacity: 0
    }
    to {
        opacity: 1
    }
  }

</style>
