<?php

namespace Tests\Unit\App\Exception;

use App\Exception\CurrencyNotFoundException;
use Exception;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * Description of CurrencyNotFoundExceptionTest
 *
 * @package Tests\Unit\App\Exception
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
final class CurrencyNotFoundExceptionTest extends TestCase
{
    /**
     * @var CurrencyNotFoundException
     */
    private $instance;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->instance = CurrencyNotFoundException::byId(1);
    }

    public function testByIdCreatesExpectedInstance(): void
    {
        $this->assertInstanceOf(CurrencyNotFoundException::class, $this->instance);
        $this->assertInstanceOf(Exception::class, $this->instance);
        $this->assertInstanceOf(Throwable::class, $this->instance);
    }

    public function testByIdCreatesInstanceWithTheExpectedMessage(): void
    {
        $this->assertSame('The currency could not be found with ID: 1!', $this->instance->getMessage());
    }

    public function testByIdCreatesInstanceWithTheDefaultCode(): void
    {
        $this->assertSame(0, $this->instance->getCode());
    }

    public function testByIdCreatesInstanceWithNullPreviousException(): void
    {
        $this->assertNull($this->instance->getPrevious());
    }
}