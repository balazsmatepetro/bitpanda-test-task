<?php

namespace App\Entity;

use App\Contract\Entity\CurrencyInterface;
use DateTimeInterface;

/**
 * Description of Currency
 *
 * @package App\Entity
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
final class Currency implements CurrencyInterface
{
    /**
     * The ID of the currency.
     *
     * @var int
     */
    private $id;

    /**
     * The name of the currency.
     *
     * @var string
     */
    private $name;

    /**
     * The symbol of the currency.
     *
     * @var string
     */
    private $symbol;

    /**
     * The description of the currency.
     *
     * @var string|null
     */
    private $description;

    /**
     * The logo of the currency.
     *
     * @var string|null
     */
    private $logo;

    /**
     * The addition date of the currency.
     *
     * @var DateTimeInterface|null
     */
    private $dateAdded;

    /**
     * The last updated date of the currency.
     *
     * @var DateTimeInterface|null
     */
    private $lastUpdated;

    /**
     * Currency constructor.
     *
     * @param int $id
     * @param string $name
     * @param string $symbol
     * @param string|null $description
     * @param string|null $logo
     * @param DateTimeInterface|null $dateAdded
     * @param DateTimeInterface|null $lastUpdated
     */
    public function __construct(
        int $id,
        string $name,
        string $symbol,
        ?string $description = null,
        ?string $logo = null,
        ?DateTimeInterface $dateAdded = null,
        ?DateTimeInterface $lastUpdated = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->symbol = $symbol;
        $this->description = $description;
        $this->logo = $logo;
        $this->dateAdded = $dateAdded;
        $this->lastUpdated = $lastUpdated;
    }

    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @inheritDoc
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @inheritDoc
     */
    public function getDateAdded(): ?DateTimeInterface
    {
        return $this->dateAdded;
    }

    /**
     * @inheritDoc
     */
    public function getLastUpdated(): ?DateTimeInterface
    {
        return $this->lastUpdated;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'symbol' => $this->symbol,
            'description' => is_null($this->description) ? '' : $this->description,
            'logo' => is_null($this->logo) ? '' : $this->logo,
            'dateAdded' => is_null($this->dateAdded) ? '' : $this->dateAdded->format('Y-m-d'),
            'lastUpdated' => is_null($this->lastUpdated) ? '' : $this->lastUpdated->format('Y-m-d H:i:s')
        ];
    }
}
