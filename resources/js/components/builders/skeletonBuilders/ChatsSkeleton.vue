<template>
  <div class="wrapper">
    <div class="list-group pl-2 pr-2">
      <div
        v-for="(item, key) in limit"
        :key="key"
        class="list-group-item no-pad "
      >
        <div class="media">
          <div class="skeleton-image skeleton-shimmer" />

          <div class="media-body p-2">
            <div class="skeleton-name skeleton-shimmer mb-1" />
            <div class="skeleton-shimmer chat-shade" />
          </div>

          <div class="skeleton-shimmer chat-badge" />
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">
import globs from '../../../tunepik/attack.js'

export default {
  name: 'ChatsSkeleton',
  data: function () {
    return {
      limit: globs.limit
    }
  }
}
</script>

<style type="text/css" scoped>
.chat-shade {
  width: 70%;
  height: 25px;
  border-radius: 8px;
}

.chat-badge {
  width: 20px;
  height: 20px;
  border-radius: 10px;
}

.list-group-item {
  border: 0;
  border-bottom: 0.03em solid rgba(211, 211, 211, 0.175);
}
</style>
