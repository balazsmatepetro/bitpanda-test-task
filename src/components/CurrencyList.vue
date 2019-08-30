<template>
  <section id="currency-list" class="container currency-list-section">
    <div class="loading-indicator-wrapper" v-if="isLoading">
      <loading-indicator></loading-indicator>
    </div>

    <div class="notification-wrapper" v-if="!isLoading && hasError">
      <div class="notification is-danger">The currencies could not be loaded!</div>  
    </div>

    <!-- This time I don't care about the empty list! -->
    
    <div v-if="!isLoading && !hasError">
      <currency-list-item
        v-for="currency in currencies"
        v-bind:key="currency.id"
        v-bind:currency="currency"
      ></currency-list-item>
    </div>
  </section>
</template>

<script lang="ts">
import { Action, Getter } from 'vuex-class';
import { Component, Vue } from 'vue-property-decorator';
import Currency from '@/interfaces/Currency';
import CurrencyListItem from './CurrencyListItem.vue';
import LoadingIndicator from './LoadingIndicator.vue';

@Component({
  components: {
    CurrencyListItem,
    LoadingIndicator,
  },
})
export default class CurrencyList extends Vue {
  @Getter('currencyList/currencies')
  private currencies!: Currency[];

  @Getter('currencyList/isLoading')
  private isLoading!: boolean;

  @Getter('currencyList/hasError')
  private hasError!: boolean;

  @Action('currencyList/findCurrencies')
  private fetchCurrencies!: any;

  public mounted() {
    this.fetchCurrencies();
  }
}
</script>

<style lang="scss" scoped>
.currency-list-section {
  height: 100%;
}
</style>

