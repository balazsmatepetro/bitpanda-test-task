import Currency from './Currency';

export default interface CurrencyDetailed extends Currency {
    /**
     * The description of the currency.
     */
    readonly description: string;

    /**
     * The logo URL.
     */
    readonly logo: string;
}
