<template>
  <div class="currency-list-item" @click="openModal(currency)">
    <div class="currency-list-item-symbol">{{ currency.symbol }}</div>
    <div class="currency-list-item-name">{{ currency.name }}</div>
    <div class="currency-list-item-date-added">{{ currency.dateAdded }}</div>
    <div class="currency-list-item-last-updated">{{ currency.lastUpdated }}</div>
  </div>
</template>

<script lang="ts">
import { Action } from 'vuex-class';
import { Component, Prop, Vue } from 'vue-property-decorator';
import Currency from '@/interfaces/Currency';

@Component
export default class CurrencyListItem extends Vue {
  @Prop()
  private currency!: Currency;

  @Action('currencyModal/openModal')
  private openModal!: void;
}
</script>

<style lang="scss" scoped>
.currency-list-item {
  cursor: pointer;
  display: flex;
  flex-direction: column;
  text-align: center;

  @include tablet() {
    flex-direction: row;
  }

  & > div {
    padding: $size-6 / 2;

    &.currency-list-item-name,
    &.currency-list-item-symbol {
      font-weight: bold;
    }

    &.currency-list-item-name {
      text-decoration: underline;
    }

    @include tablet() {
      &.currency-list-item-date-added {
        width: 200px;
      }

      &.currency-list-item-name {
        width: 100%;
      }

      &.currency-list-item-last-updated {
        min-width: 200px;
      }

      &.currency-list-item-symbol {
        min-width: 100px;
      }
    }
  }

  &:not(:last-child) {
    border-bottom: 1px solid $primary;
  }
}
</style>

