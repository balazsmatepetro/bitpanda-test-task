<?php

namespace App\Contract\Repository;

use App\Contract\Entity\CurrencyInterface;
use App\Exception\CurrencyNotFoundException;

/**
 * Description of CurrencyRepositoryInterface
 *
 * @package App\Contract\Repository\CurrencyRepository
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
interface CurrencyRepositoryInterface
{
    /**
     * Finds and returns all available currencies.
     *
     * @return CurrencyInterface[]
     */
    public function findAll(): array;

    /**
     * Finds and returns the currency by the given ID.
     *
     * @param int $id The currency ID.
     * @return CurrencyInterface The found currency.
     * @throws CurrencyNotFoundException Thrown when the currency could not be found.
     */
    public function findById(int $id): CurrencyInterface;
}
