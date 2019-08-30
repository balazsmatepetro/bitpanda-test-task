<?php

namespace App\Repository;

use App\Contract\Entity\CurrencyInterface;
use App\Contract\Repository\CurrencyRepositoryInterface;
use App\Entity\Currency;
use App\Exception\CurrencyNotFoundException;
use DateTimeImmutable;
use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use stdClass;

class CoinMarketApiCurrencyRepository implements CurrencyRepositoryInterface
{
    /**
     * The API client.
     *
     * @var ClientInterface
     */
    private $client;

    /**
     * CoinMarketApiCurrencyRepository constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     * @throws Exception Thrown when the response could not be parsed.
     */
    public function findAll(): array
    {
        try {
            return array_map([$this, 'parseCurrency'], $this->callApi('listings/latest')->data);
        } catch (ClientException $ex) {
            throw new Exception('The currencies could not be loaded!');
        }
    }

    /**
     * @inheritDoc
     * @throws Exception Thrown when the response could not be parsed.
     */
    public function findById(int $id): CurrencyInterface
    {
        try {
            return $this->parseCurrency($this->callApi('info', ['query' => compact('id')])->data->{$id});
        } catch (ClientException $ex) {
            // NOTE: The 'info' endpoint doesn't respond with status code 404, so this time we don't care too
            // much about the received HTTP status code, we will treat this case as a 'not found'.
            throw CurrencyNotFoundException::byId($id);
        }
    }

    /**
     * Performs an API call by the given arguments and returns the response.
     *
     * @param string $endpoint The API endpoint to call.
     * @param array $arguments The request arguments.
     * @return stdClass The response.
     * @throws Exception Thrown when the response could not be parsed.
     */
    private function callApi(string $endpoint, array $arguments = []): stdClass
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $content = json_decode($this->client->get($endpoint, $arguments)->getBody());

        if (!property_exists($content, 'data')) {
            throw new Exception('The \'data\' property does not exist!');
        }

        return $content;
    }

    /**
     * Creates a currency instance by the given data.
     *
     * @param stdClass $currency The currency to parse.
     * @return Currency The parsed currency.
     */
    private function parseCurrency(stdClass $currency): Currency
    {
        return new Currency(
            $currency->id,
            $currency->name,
            $currency->symbol,
            property_exists($currency, 'description') ? $currency->description : null,
            property_exists($currency, 'logo') ? $currency->logo : null,
            property_exists($currency, 'date_added') ? $this->parseDate($currency->{'date_added'}) : null,
            property_exists($currency, 'last_updated') ? $this->parseDate($currency->{'last_updated'}) : null
        );
    }

    /**
     * Creates a date time instance by the given date.
     *
     * @param string $date The date to parse.
     * @return DateTimeImmutable The parsed date.
     */
    private function parseDate(string $date): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.v\Z', $date);
    }
}
