<?php

namespace App\Contract\Service;

use App\Exception\ImageDecodeException;

/**
 * Description of DecodeImageService
 *
 * @package App\Contract\Service
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
interface DecodeImageService
{
    /**
     * Decodes the image by the given URL and returns is in a decoded format.
     *
     * @param string $imageUrl The image URL.
     * @return string The decoded image.
     * @throws ImageDecodeException Thrown when the image could not be decoded.
     */
    public function execute(string $imageUrl): string;
}
