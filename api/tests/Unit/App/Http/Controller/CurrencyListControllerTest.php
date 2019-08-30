<?php

namespace Tests\Unit\App\Http\Controller;

use App\Http\Controller\CurrencyListController;
use Exception;

/**
 * Description of CurrencyListControllerTest
 *
 * @package Tests\Unit\App\Http\Controller
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
final class CurrencyListControllerTest extends AbstractCurrencyControllerTest
{
    public function testExecuteRespondsWithErrorWhenTheRepositoryCallFails(): void
    {
        $repositoryMock = $this->createRepositoryMock();
        $repositoryMock->shouldReceive('findAll')->once()->andThrow(new Exception);

        $responseMock = $this->createResponseMock();
        $responseMock->shouldReceive('withJson')->once()->with('Unexpected server error!', 500)->andReturnSelf();

        (new CurrencyListController($repositoryMock))->execute($this->createRequestMock(), $responseMock);
    }

    public function testExecuteRespondsWithOkWhenTheCurrencyCanBeFound(): void
    {
        $currencies = [
            $this->createCurrencyMock(),
            $this->createCurrencyMock()
        ];

        $repositoryMock = $this->createRepositoryMock();
        $repositoryMock->shouldReceive('findAll')->once()->andReturn($currencies);

        $responseMock = $this->createResponseMock();
        $responseMock->shouldReceive('withJson')->once()->with($currencies)->andReturnSelf();

        (new CurrencyListController($repositoryMock))->execute($this->createRequestMock(), $responseMock);
    }
}
