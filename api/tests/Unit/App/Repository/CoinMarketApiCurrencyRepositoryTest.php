<?php

namespace Tests\Unit\App\Repository;

use App\Contract\Entity\CurrencyInterface;
use App\Exception\CurrencyNotFoundException;
use App\Repository\CoinMarketApiCurrencyRepository;
use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use stdClass;

/**
 * Description of CoinMarketApiCurrencyRepositoryTest
 *
 * @package Tests\Unit\App\Repository
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
final class CoinMarketApiCurrencyRepositoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testFindAllThrowsExceptionOnApiCallFailure(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The currencies could not be loaded!');

        $clientMock = $this->createClientMock();
        $clientMock->shouldReceive('get')
            ->once()
            ->with('listings/latest', [])
            ->andThrow(new ClientException('API error!', $this->createRequestMock()));

        /** @noinspection PhpUndefinedMethodInspection */
        (new CoinMarketApiCurrencyRepository($clientMock))->findAll();
    }

    public function testFindAllThrowsExceptionWhenTheResponseDoesNotContainDataProperty(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The \'data\' property does not exist!');

        $responseMock = $this->createResponseMock();
        $responseMock->shouldReceive('getBody')->once()->andReturn(json_encode(new stdClass));

        $clientMock = $this->createClientMock();
        $clientMock->shouldReceive('get')->once()->with('listings/latest', [])->andReturn($responseMock);

        /** @noinspection PhpUndefinedMethodInspection */
        (new CoinMarketApiCurrencyRepository($clientMock))->findAll();
    }

    public function testFindAllReturnsCurrencyListOnSuccessfulApiCall(): void
    {
        $currency0 = new stdClass;
        $currency0->id = 1;
        $currency0->name = 'Currency 1';
        $currency0->symbol = 'CUR-1';

        $currency1 = new stdClass;
        $currency1->id = 2;
        $currency1->name = 'Currency 2';
        $currency1->symbol = 'CUR-2';
        $currency1->description = 'Description';
        $currency1->logo = 'logo.png';
        $currency1->date_added = '2019-05-01T10:20:30.000Z';
        $currency1->last_updated = '2019-05-30T08:00:00.000Z';

        $response = new stdClass;
        $response->data = [
            $currency0,
            $currency1
        ];

        $responseMock = $this->createResponseMock();
        $responseMock->shouldReceive('getBody')->once()->andReturn(json_encode($response));

        $clientMock = $this->createClientMock();
        $clientMock->shouldReceive('get')->once()->with('listings/latest', [])->andReturn($responseMock);

        /** @noinspection PhpUndefinedMethodInspection */
        $result = (new CoinMarketApiCurrencyRepository($clientMock))->findAll();

        $this->assertTrue(is_array($result));
        $this->assertCount(2, $result);

        /**
         * @var CurrencyInterface $currencyInstance0
         */
        $currencyInstance0 = $result[0];

        $this->assertTrue(is_object($currencyInstance0));
        $this->assertInstanceOf(CurrencyInterface::class, $currencyInstance0);
        $this->assertSame(1, $currencyInstance0->getId());
        $this->assertSame('Currency 1', $currencyInstance0->getName());
        $this->assertSame('CUR-1', $currencyInstance0->getSymbol());
        $this->assertNull($currencyInstance0->getDescription());
        $this->assertNull($currencyInstance0->getLogo());
        $this->assertNull($currencyInstance0->getDateAdded());
        $this->assertNull($currencyInstance0->getLastUpdated());

        /**
         * @var CurrencyInterface $currencyInstance1
         */
        $currencyInstance1 = $result[1];

        $this->assertTrue(is_object($currencyInstance1));
        $this->assertInstanceOf(CurrencyInterface::class, $currencyInstance1);
        $this->assertSame(2, $currencyInstance1->getId());
        $this->assertSame('Currency 2', $currencyInstance1->getName());
        $this->assertSame('CUR-2', $currencyInstance1->getSymbol());
        $this->assertSame('Description', $currencyInstance1->getDescription());
        $this->assertSame('logo.png', $currencyInstance1->getLogo());
        $this->assertSame('2019-05-01 10:20:30', $currencyInstance1->getDateAdded()->format('Y-m-d H:i:s'));
        $this->assertSame('2019-05-30 08:00:00', $currencyInstance1->getLastUpdated()->format('Y-m-d H:i:s'));
    }

    public function testFindByIdThrowsCurrencyNotFoundExceptionOnApiCallFailure(): void
    {
        $this->expectException(CurrencyNotFoundException::class);
        $this->expectExceptionMessage('The currency could not be found with ID: 1!');

        $clientMock = $this->createClientMock();
        $clientMock->shouldReceive('get')
            ->once()
            ->with('info', ['query' => ['id' => 1]])
            ->andThrow(new ClientException('API error!', $this->createRequestMock()));

        /** @noinspection PhpUndefinedMethodInspection */
        (new CoinMarketApiCurrencyRepository($clientMock))->findById(1);
    }

    public function testFindByIdThrowsExceptionWhenTheResponseDoesNotContainDataProperty(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The \'data\' property does not exist!');

        $responseMock = $this->createResponseMock();
        $responseMock->shouldReceive('getBody')->once()->andReturn(json_encode(new stdClass));

        $clientMock = $this->createClientMock();
        $clientMock->shouldReceive('get')->once()->with('info', ['query' => ['id' => 1]])->andReturn($responseMock);

        /** @noinspection PhpUndefinedMethodInspection */
        (new CoinMarketApiCurrencyRepository($clientMock))->findById(1);
    }

    public function testFindByIdReturnsCurrencyInstanceOnSuccessfulApiCall(): void
    {
        $currency1 = new stdClass;
        $currency1->id = 1;
        $currency1->name = 'Currency 1';
        $currency1->symbol = 'CUR-1';
        $currency1->description = 'Description';
        $currency1->logo = 'logo.png';
        $currency1->date_added = '2019-05-01T10:20:30.000Z';
        $currency1->last_updated = '2019-05-30T08:00:00.000Z';

        $response = new stdClass;
        $response->data = [1 => $currency1];

        $responseMock = $this->createResponseMock();
        $responseMock->shouldReceive('getBody')->once()->andReturn(json_encode($response));

        $clientMock = $this->createClientMock();
        $clientMock->shouldReceive('get')->once()->with('info', ['query' => ['id' => 1]])->andReturn($responseMock);

        /** @noinspection PhpUndefinedMethodInspection */
        $currency = (new CoinMarketApiCurrencyRepository($clientMock))->findById(1);

        $this->assertTrue(is_object($currency));
        $this->assertInstanceOf(CurrencyInterface::class, $currency);
        $this->assertSame(1, $currency->getId());
        $this->assertSame('Currency 1', $currency->getName());
        $this->assertSame('CUR-1', $currency->getSymbol());
        $this->assertSame('Description', $currency->getDescription());
        $this->assertSame('logo.png', $currency->getLogo());
        $this->assertSame('2019-05-01 10:20:30', $currency->getDateAdded()->format('Y-m-d H:i:s'));
        $this->assertSame('2019-05-30 08:00:00', $currency->getLastUpdated()->format('Y-m-d H:i:s'));
    }

    /**
     * Creates and returns a Guzzle Client mock.
     *
     * @return MockInterface|ClientInterface
     */
    private function createClientMock(): MockInterface
    {
        return Mockery::mock(ClientInterface::class);
    }

    /**
     * Creates and returns a RequestInterface mock.
     *
     * @return MockInterface|RequestInterface
     */
    private function createRequestMock(): MockInterface
    {
        return Mockery::mock(RequestInterface::class);
    }

    /**
     * Creates and returns a ResponseInterface mock.
     *
     * @return MockInterface|ResponseInterface
     */
    private function createResponseMock(): MockInterface
    {
        return Mockery::mock(ResponseInterface::class);
    }
}
