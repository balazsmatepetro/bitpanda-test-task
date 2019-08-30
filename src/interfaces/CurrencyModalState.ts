import CurrencyDetailed from './CurrencyDetailed';
import LoadingAwareState from './LoadingAwareState';

export default interface CurrencyListState extends LoadingAwareState {
    /**
     * The selected currency.
     */
    currency?: CurrencyDetailed;

    /**
     * The modal window is visible or not.
     */
    visible: boolean;
}
