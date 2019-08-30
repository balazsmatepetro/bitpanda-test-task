<?php

namespace App\Exception;

use Exception;

/**
 * Description of ImageDecodeException
 *
 * @package App\Exception
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
final class ImageDecodeException extends Exception
{
    /**
     * Creates a new exception instance by the given image URL.
     *
     * @param string $imageUrl The image URL.
     * @return ImageDecodeException
     */
    public static function byImageUrl(string $imageUrl): self
    {
        return new self(sprintf('The image \'%s\' could not be decoded!', $imageUrl));
    }
}
