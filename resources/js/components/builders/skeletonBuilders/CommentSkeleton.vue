<template>
  <div class="wrapper">
    <div v-for="(item, i) in list" class="list-group">
      <div class="list-group-item">
        <div class="media">
          <div
            class="media-left align-self-start skeleton-shimmer skeleton-image"
          />

          <div class="media-body pl-2 align-self-center">
            <div class="media">
              <div class="media-body align-self-center">
                <div class="skeleton-shimmer skeleton-name" />
              </div>
              <div class="media-right align-self-center">
                <div class="options-shade skeleton-shimmer" />
              </div>
            </div>

            <div class="space-small" />

            <div class="skeleton-shimmer block-shade" />

            <div class="space-small" />

            <div class="media">
              <div class="media-body align-self-center">
                <div class="skeleton-shimmer date-shade mt-2" />
              </div>
              <div class="media-right align-self-center">
                <Icon :icon="'heartEmpty'" :width="16" :height="16" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">
import globs from '../../../tunepik/attack.js'

export default {
  name: 'CommentSkeleton',
  data: function () {
    return {
      list: globs.limit
    }
  }
}
</script>

<style type="text/css" scoped>
.date-shade {
  width: 100px;
  height: 15px;
  border-radius: 6px;
}

.options-shade {
  width: 20px;
  height: 20px;
  border-radius: 15px;
}

.block-shade {
  width: 100%;
  height: 100px;
}

.list-group-item {
  border: 0;
  border-bottom: 0.04em solid rgba(211, 211, 211, 0.4);
}
</style>
