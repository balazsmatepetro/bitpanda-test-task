import { ActionContext, ActionTree, GetterTree, MutationTree } from 'vuex';
import Currency from '@/interfaces/Currency';
import CurrencyDetailed from '@/interfaces/CurrencyDetailed';
import CurrencyModalState from '@/interfaces/CurrencyModalState';
import CurrencyService from '@/services/CurrencyService';

const data: CurrencyModalState = {
    currency: undefined,
    loading: false,
    hasError: false,
    visible: false,
};

const getters: GetterTree<CurrencyModalState, any> = {
    currency(state: CurrencyModalState): CurrencyDetailed | undefined {
        return state.currency;
    },

    hasError(state: CurrencyModalState): boolean {
        return state.hasError;
    },

    isLoading(state: CurrencyModalState): boolean {
        return state.loading;
    },

    isVisible(state: CurrencyModalState): boolean {
        return state.visible;
    },
};

const mutations: MutationTree<CurrencyModalState> = {
    changeCurrency(state: CurrencyModalState, currency: CurrencyDetailed | undefined): void {
        state.currency = currency;
    },

    error(state: CurrencyModalState, hasError: boolean): void {
        state.hasError = hasError;
    },

    loading(state: CurrencyModalState, isLoading: boolean): void {
        state.loading = isLoading;
    },

    visible(state: CurrencyModalState, isVisible: boolean): void {
        state.visible = isVisible;
    },
};

const actions: ActionTree<CurrencyModalState, any> = {
    closeModal(context: ActionContext<CurrencyModalState, any>): void {
        context.commit('loading', false);
        context.commit('visible', false);
        context.commit('changeCurrency', undefined);
        context.commit('error', false);
    },

    openModal(context: ActionContext<CurrencyModalState, any>, currency: Currency): void {
        context.commit('visible', true);
        context.commit('loading', true);
        context.commit('error', false);

        new CurrencyService().getCurrency(currency.id)
            .then((response) => {
                context.commit('changeCurrency', response.data);
            })
            .catch(() => {
                context.commit('error', true);
            })
            .finally(() => {
                context.commit('loading', false);
            });
    },
};

export const currencyModal = {
    namespaced: true,
    state: data,
    getters,
    actions,
    mutations,
};
