<template>
  <div class="loading-indicator">
    <div></div>
    <div></div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class LoadingIndicator extends Vue {}
</script>

<style lang="scss" scoped>
.loading-indicator {
  display: inline-block;
  height: 64px;
  position: relative;
  width: 64px;
}

.loading-indicator > div {
  animation: loading-indicator 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
  border: 4px solid $primary;
  border-radius: 50%;
  opacity: 1;
  position: absolute;
}

.loading-indicator > div:nth-child(2) {
  animation-delay: -0.5s;
}

@keyframes loading-indicator {
  0% {
    height: 0;
    left: 28px;
    opacity: 1;
    top: 28px;
    width: 0;
  }
  100% {
    height: 58px;
    left: -1px;
    opacity: 0;
    top: -1px;
    width: 58px;
  }
}
</style>

