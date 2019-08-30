<?php

namespace App\Exception;

use Exception;

/**
 * Description of CurrencyNotFoundException
 *
 * @package App\Exception
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
final class CurrencyNotFoundException extends Exception
{
    /**
     * Creates a new exception instance by the given currency ID.
     *
     * @param int $id The currency ID.
     * @return CurrencyNotFoundException
     */
    public static function byId(int $id): self
    {
        return new self(sprintf('The currency could not be found with ID: %d!', $id));
    }
}
