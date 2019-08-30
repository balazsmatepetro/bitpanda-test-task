<template>
  <div class="modal" v-bind:class="{ 'is-active': isVisible }" @click="closeModal" v-if="isVisible">
    <div class="modal-background"></div>
    <div class="modal-card" @click.stop>
      <header class="modal-card-head">
        <p class="modal-card-title">Currency Details</p>
        <button class="delete" aria-label="close" @click="closeModal"></button>
      </header>

      <section class="modal-card-body">
        <div class="loading-indicator-wrapper" v-if="isLoading">
          <loading-indicator></loading-indicator>
        </div>

        <div class="notification-wrapper" v-if="!isLoading && hasError">
          <div class="notification is-danger">The currency could not be loaded!</div>
        </div>

        <div v-if="!isLoading && !hasError">
          <div class="currency-detail-media">
            <div class="currency-detail-media-image-container">
              <img class="image is-64x64" v-bind:src="currency.logo" v-bind:alt="currency.name">
            </div>

            <div class="currency-detail-media-table-container">
              <table class="table is-bordered is-narrow">
                <tr>
                  <td>Name:</td>
                  <td>{{ currency.name }}</td>
                </tr>

                <tr>
                  <td>Symbol:</td>
                  <td>{{ currency.symbol }}</td>
                </tr>

                <tr>
                  <td>Date Added:</td>
                  <td>{{ currency.dateAdded }}</td>
                </tr>
              </table>
            </div>
          </div>

          <div>{{ currency.description }}</div>
        </div>
      </section>
    </div>
  </div>
</template>

<script lang="ts">
import { Action, Getter } from 'vuex-class';
import { Component, Vue } from 'vue-property-decorator';
import LoadingIndicator from './LoadingIndicator.vue';
import CurrencyDetailed from '../interfaces/CurrencyDetailed';

@Component({
  components: {
    LoadingIndicator,
  },
})
export default class CurrencyModal extends Vue {
  @Getter('currencyModal/currency')
  private currency!: CurrencyDetailed;

  @Getter('currencyModal/hasError')
  private hasError!: boolean;

  @Getter('currencyModal/isLoading')
  private isLoading!: boolean;

  @Getter('currencyModal/isVisible')
  private isVisible!: boolean;

  @Action('currencyModal/closeModal')
  private closeModal!: any;

  public mounted() {
    document.addEventListener('keydown', (event) => {
      if (this.isVisible && event.keyCode == 27) {
        this.closeModal();
      }
    });
  }
}
</script>

<style lang="scss" scoped>
.currency-detail-media {
  align-items: center;
  display: flex;
  flex-direction: column;
  justify-content: center;
  margin-bottom: $size-3;

  @include tablet() {
    flex-direction: row;
  }
}

.currency-detail-media-image-container {
  margin-bottom: 20px;

  @include tablet() {
    margin-bottom: 0;
    width: 150px;
  }

  & > .image {
    margin: 0 auto;
  }
}

.currency-detail-media-table-container,
.currency-detail-media-table-container > .table {
  width: 100%;
}

.currency-detail-media-table-container {
  & > .table {
    & > tr {
      & > td:first-child {
        font-weight: bold;
        text-align: right;

        @include tablet() {
          width: 150px;
        }
      }
    }
  }
}

.modal-card {
  height: 90%;
  width: 90%;

  @include desktop() {
    width: 70%;
  }
}

.modal-card-body {
  border-bottom-left-radius: $modal-card-body-radius;
  border-bottom-right-radius: $modal-card-body-radius;

  & > .loading-indicator-wrapper, .notification-wrapper {
    height: 100%;
  }
}
</style>
