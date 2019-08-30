<?php

namespace Tests\Unit\App\Http\Controller;

use App\Contract\Entity\CurrencyInterface;
use App\Contract\Repository\CurrencyRepositoryInterface;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Description of AbstractCurrencyControllerTest
 *
 * @package Tests\Unit\App\Http\Controller
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
abstract class AbstractCurrencyControllerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Creates and returns a currency mock.
     *
     * @return MockInterface|CurrencyInterface
     */
    protected function createCurrencyMock(): MockInterface
    {
        return Mockery::mock(CurrencyInterface::class);
    }

    /**
     * Creates and returns a request mock.
     *
     * @return MockInterface|Request
     */
    protected function createRequestMock(): MockInterface
    {
        return Mockery::mock(Request::class);
    }

    /**
     * Creates and returns a respons mock.
     *
     * @return MockInterface|Response
     */
    protected function createResponseMock(): MockInterface
    {
        return Mockery::mock(Response::class);
    }

    /**
     * Creates and returns a currency repository mock.
     *
     * @return MockInterface|CurrencyRepositoryInterface
     */
    protected function createRepositoryMock(): MockInterface
    {
        return Mockery::mock(CurrencyRepositoryInterface::class);
    }
}
