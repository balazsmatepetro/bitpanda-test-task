import { ActionContext, ActionTree, GetterTree, MutationTree } from 'vuex';
import Currency from '@/interfaces/Currency';
import CurrencyListState from '@/interfaces/CurrencyListState';
import CurrencyService from '@/services/CurrencyService';

const data: CurrencyListState = {
    currencies: [],
    loading: false,
    hasError: false,
};

const getters: GetterTree<CurrencyListState, any> = {
    currencies(state: CurrencyListState): Currency[] {
        return state.currencies;
    },

    hasError(state: CurrencyListState): boolean {
        return state.hasError;
    },

    isLoading(state: CurrencyListState): boolean {
        return state.loading;
    },
};

const mutations: MutationTree<CurrencyListState> = {
    addCurrency(state: CurrencyListState, currency: Currency): void {
        state.currencies.push(currency);
    },

    error(state: CurrencyListState, hasError: boolean): void {
        state.hasError = hasError;
    },

    loading(state: CurrencyListState, isLoading: boolean): void {
        state.loading = isLoading;
    },
};

const actions: ActionTree<CurrencyListState, any> = {
    findCurrencies(context: ActionContext<CurrencyListState, any>): void {
        context.commit('loading', true);
        context.commit('error', false);

        new CurrencyService().getCurrencies()
            .then((response) => {
                response.data.forEach((currency: Currency) => {
                    context.commit('addCurrency', currency);
                });
            })
            .catch(() => {
                context.commit('error', true);
            })
            .finally(() => {
                context.commit('loading', false);
            });
    },
};

export const currencyList = {
    namespaced: true,
    state: data,
    getters,
    actions,
    mutations,
};
