import axios, { AxiosPromise } from 'axios';
import Currency from '@/interfaces/Currency';

// TODO: This should be retrieved from config or somewhere else.
const apiEndpont = 'http://localhost:9000/v1';

export default class CurrencyService {
    public getCurrencies(): AxiosPromise<Currency[]> {
        return axios.get(`${apiEndpont}/currencies`);
    }

    public getCurrency(id: number): AxiosPromise<Currency> {
        return axios.get(`${apiEndpont}/currencies/${id}`);
    }
}
