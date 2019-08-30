<template>
  <div id="app">
    <header class="header hero is-primary">
      <div class="hero-body">
        <div class="container">
          <h1 class="title">BitPanda Test Task</h1>
        </div>
      </div>
    </header>

    <main>
      <currency-list></currency-list>
      <currency-modal></currency-modal>
    </main>

    <footer class="footer">
      <div class="content">
        <p>
          Created by
          <a href="https://github.com/balazsmatepetro" target="_blank">Balázs Máté Petró</a>
        </p>
      </div>
    </footer>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import CurrencyList from './components/CurrencyList.vue';
import CurrencyModal from './components/CurrencyModal.vue';

require('../src/scss/app.scss');

@Component({
  components: {
    CurrencyList,
    CurrencyModal,
  },
})
export default class App extends Vue {}
</script>

<style lang="scss" scoped>
main {
  height: calc(100% - #{($header-height + $footer-height)});
  overflow: scroll;
}

.header {
  height: $header-height;

  &.hero > .hero-body {
    align-items: center;
    display: flex;
    padding: 0;
  }

  .title {
    font-size: $size-4;
    font-weight: bold;
    text-align: center;
  }
}

.footer {
  color: findColorInvert($text);
  height: $footer-height;
  line-height: $footer-height;
  padding: 0;
  text-align: center;

  a {
    color: findColorInvert($link);
    text-decoration: underline;
  }
}
</style>
