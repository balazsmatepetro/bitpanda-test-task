import Currency from './Currency';
import LoadingAwareState from './LoadingAwareState';

export default interface CurrencyListState extends LoadingAwareState {
    /**
     * The list of the available currencies.
     */
    currencies: Currency[];
}
