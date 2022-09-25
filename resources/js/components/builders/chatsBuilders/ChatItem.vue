<template>
  <router-link
    :to="{ name: 'messages', params: { username: message.getBasic().handle } }"
  >
    <a
      @click="
        MESSAGE_USER({ error: false, message: 'User Found', user: message })
      "
    >
      <div class="media">
        <div class="media-left">
          <Picture :width="45" :height="45" :user="message" />
        </div>
        <div class="media-body pl-3">
          <span class="block-text app-bolder-text">
            {{ trim(message.getBasic().name, 20) }}
          </span>
          <span v-if="message.getChat().type == 'text'" class="app-post-text">
            {{ trim(message.getChat().message, 50) }}
          </span>
          <span v-else class="app-post-text">
            {{ message.getBasic().name }} sent a {{ message.getChat().type }}
          </span>

          <span class="block-text app-grey-text">
            {{ message.getChat().now }}
          </span>
        </div>
        <div class="media-right align-self-center">
          <center>
            <div
              class="app-badge"
              :style="{ backgroundColor: theme.icons.color }"
            >
              {{ message.getChat().count }}
            </div>
          </center>
        </div>
      </div>
    </a>
  </router-link>
</template>

<script type="text/javascript">
import { mapMutations, mapGetters } from 'vuex'
import globs from '../../../tunepik/attack.js'

export default {
  name: 'ChatItem',
  // eslint-disable-next-line vue/require-prop-types
  props: ['message'],
  data: () => ({
    trim: globs.trim
  }),
  computed: {
    ...mapGetters('tunepik', ['theme'])
  },
  methods: {
    ...mapMutations('messages', ['MESSAGE_USER'])
  }
}
</script>

<style type="text/css" scoped></style>
