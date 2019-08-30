<?php

namespace Tests\Unit\App\Http\Controller;

use App\Contract\Entity\CurrencyInterface;
use App\Contract\Service\DecodeImageService;
use App\Exception\CurrencyNotFoundException;
use App\Http\Controller\CurrencyController;
use Exception;
use Mockery;
use Mockery\MockInterface;

/**
 * Description of CurrencyControllerTest
 *
 * @package Tests\Unit\App\Http\Controller
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
final class CurrencyControllerTest extends AbstractCurrencyControllerTest
{
    public function testExecuteRespondsWithErrorWhenTheRepositoryCallFails(): void
    {
        $repositoryMock = $this->createRepositoryMock();
        $repositoryMock->shouldReceive('findById')->once()->with(1)->andThrow(new Exception);

        $requestMock = $this->createRequestMock();
        $requestMock->shouldReceive('getAttribute')->once()->with('id', 0)->andReturn(1);

        $responseMock = $this->createResponseMock();
        $responseMock->shouldReceive('withJson')->once()->with('Unexpected server error!', 500)->andReturnSelf();

        $decodeImageServiceMock = $this->createDecodeImageServiceMock();
        $decodeImageServiceMock->shouldNotReceive('execute');

        (new CurrencyController($repositoryMock, $decodeImageServiceMock))->execute($requestMock, $responseMock);
    }

    public function testExecuteRespondsWithNotFoundWhenTheCurrencyCouldNotBeFound(): void
    {
        $exception = CurrencyNotFoundException::byId(1);

        $repositoryMock = $this->createRepositoryMock();
        $repositoryMock->shouldReceive('findById')->once()->with(1)->andThrow($exception);

        $requestMock = $this->createRequestMock();
        $requestMock->shouldReceive('getAttribute')->once()->with('id', 0)->andReturn(1);

        $responseMock = $this->createResponseMock();
        $responseMock->shouldReceive('withJson')->once()->with($exception->getMessage(), 404)->andReturnSelf();

        $decodeImageServiceMock = $this->createDecodeImageServiceMock();
        $decodeImageServiceMock->shouldNotReceive('execute');

        (new CurrencyController($repositoryMock, $decodeImageServiceMock))->execute($requestMock, $responseMock);
    }

    public function testExecuteRespondsWithOkWhenTheCurrencyCanBeFound(): void
    {
        $currency = $this->createCurrencyMock();
        $currency->shouldReceive('getId')->once()->andReturn(1);
        $currency->shouldReceive('getName')->once()->andReturn('Currency');
        $currency->shouldReceive('getSymbol')->once()->andReturn('CUR-1');
        $currency->shouldReceive('getDescription')->once()->andReturn('Description');
        $currency->shouldReceive('getLogo')->once()->andReturn('logo.png');
        $currency->shouldReceive('getDateAdded')->once()->andReturn(null);
        $currency->shouldReceive('getLastUpdated')->once()->andReturn(null);

        $repositoryMock = $this->createRepositoryMock();
        $repositoryMock->shouldReceive('findById')->once()->with(1)->andReturn($currency);

        $requestMock = $this->createRequestMock();
        $requestMock->shouldReceive('getAttribute')->once()->with('id', 0)->andReturn(1);

        $responseMock = $this->createResponseMock();
        $responseMock->shouldReceive('withJson')->once()->withArgs(function (CurrencyInterface $currency) {
            return $currency->getId() === 1 &&
                $currency->getName() === 'Currency' &&
                $currency->getSymbol() === 'CUR-1' &&
                $currency->getDescription() === 'Description' &&
                $currency->getLogo() === 'logo-content' &&
                is_null($currency->getDateAdded()) &&
                is_null($currency->getLastUpdated());
        })->andReturnSelf();

        $decodeImageServiceMock = $this->createDecodeImageServiceMock();
        $decodeImageServiceMock->shouldReceive('execute')->once()->with('logo.png')->andReturn('logo-content');

        (new CurrencyController($repositoryMock, $decodeImageServiceMock))->execute($requestMock, $responseMock);
    }

    /**
     * Creates and returns a decode image service mock.
     *
     * @return MockInterface|DecodeImageService
     */
    private function createDecodeImageServiceMock(): MockInterface
    {
        return Mockery::mock(DecodeImageService::class);
    }
}
