export default interface LoadingAwareState {
    /**
     * The resource is being loaded or not.
     */
    loading: boolean;

    /**
     * The resounce loading was successful or not.
     */
    hasError: boolean;
}
