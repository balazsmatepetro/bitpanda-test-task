<?php

namespace Tests\Unit\App\Entity;

use App\Entity\Currency;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Description of CurrencyTest
 *
 * @package Tests\Unit\App\Entity
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
final class CurrencyTest extends TestCase
{
    /**
     * @var Currency
     */
    private $withOptionals;

    /**
     * @var Currency
     */
    private $withoutOptionals;

    /**
     * @var DateTime
     */
    private $dateAdded;

    /**
     * @var DateTime
     */
    private $lastUpdated;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->dateAdded = DateTime::createFromFormat('Y-m-d', '2011-05-30');
        $this->lastUpdated = DateTime::createFromFormat('Y-m-d', '2019-05-30');
        $this->withOptionals = new Currency(1, 'Currency 1', 'CUR-1');
        $this->withoutOptionals = new Currency(
            2,
            'Currency 2',
            'CUR-2',
            'Description',
            'logo',
            $this->dateAdded,
            $this->lastUpdated
        );
    }

    public function testGetIdReturnsTheExpectedValue(): void
    {
        $this->assertSame(1, $this->withOptionals->getId());
        $this->assertSame(2, $this->withoutOptionals->getId());
    }

    public function testGetNameReturnsTheExpectedValue(): void
    {
        $this->assertSame('Currency 1', $this->withOptionals->getName());
        $this->assertSame('Currency 2', $this->withoutOptionals->getName());
    }

    public function testGetSymbolReturnsTheExpectedValue(): void
    {
        $this->assertSame('CUR-1', $this->withOptionals->getSymbol());
        $this->assertSame('CUR-2', $this->withoutOptionals->getSymbol());
    }

    public function testGetDescriptionReturnsTheExpectedValue(): void
    {
        $this->assertNull($this->withOptionals->getDescription());
        $this->assertSame('Description', $this->withoutOptionals->getDescription());
    }

    public function testGetLogoReturnsTheExpectedValue(): void
    {
        $this->assertNull($this->withOptionals->getLogo());
        $this->assertSame('logo', $this->withoutOptionals->getLogo());
    }

    public function testGetDateAddedReturnsTheExpectedValue(): void
    {
        $this->assertNull($this->withOptionals->getDateAdded());
        $this->assertSame($this->dateAdded, $this->withoutOptionals->getDateAdded());
    }

    public function testGetLastUpdatedReturnsTheExpectedValue(): void
    {
        $this->assertNull($this->withOptionals->getLastUpdated());
        $this->assertSame($this->lastUpdated, $this->withoutOptionals->getLastUpdated());
    }
}
