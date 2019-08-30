export default interface Currency {
    /**
     * The ID of the currency.
     */
    readonly id: number;

    /**
     * The name of the currency.
     */
    readonly name: string;

    /**
     * The symbol of the currency.
     */
    readonly symbol: string;

    /**
     * The addition date of the currency.
     * (It's coming from the server in a proper format, that's why I treat it as string)
     */
    readonly dateAdded?: Date;

    /**
     * The last modification of the currency.
     * (It's coming from the server in a proper format, that's why I treat it as string)
     */
    readonly lastUpdated?: Date;
}
