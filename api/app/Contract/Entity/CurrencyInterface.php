<?php

namespace App\Contract\Entity;

use DateTimeInterface;
use JsonSerializable;

/**
 * Description of CurrencyInterface
 *
 * @package App\Contract\Entity
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
interface CurrencyInterface extends JsonSerializable
{
    /**
     * Returns the ID of the currency.
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Returns the name of the currency.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Returns the symbol of the currency.
     *
     * @return string
     */
    public function getSymbol(): string;

    /**
     * Returns the description of the currency.
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Returns the logo of the currency.
     *
     * @return string|null
     */
    public function getLogo(): ?string;

    /**
     * Returns the addition date of the currency.
     *
     * @return DateTimeInterface|null
     */
    public function getDateAdded(): ?DateTimeInterface;

    /**
     * Returns the last updated date of the currency.
     *
     * @return DateTimeInterface|null
     */
    public function getLastUpdated(): ?DateTimeInterface;
}
