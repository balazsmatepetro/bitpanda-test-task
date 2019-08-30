<?php

namespace App\Service;

use App\Contract\Service\DecodeImageService;
use App\Exception\ImageDecodeException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;

/**
 * Description of Base64DecodeRemoteImageService
 *
 * @package App\Service
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
class Base64DecodeRemoteImageService implements DecodeImageService
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * Base64DecodeRemoteImageService constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function execute(string $imageUrl): string
    {
        return 'data:image/png;base64,' . base64_encode($this->fetchImageContent($imageUrl));
    }

    /**
     * Reads and returns the content of the image.
     *
     * @param string $imageUrl The image URL.
     * @return string The decoded content of the image.
     * @throws ImageDecodeException Thrown when the image could not be decoded.
     */
    private function fetchImageContent(string $imageUrl): string
    {
        try {
            /** @noinspection PhpUndefinedMethodInspection */
            return $this->client->get($imageUrl)->getBody()->getContents();
        } catch (ClientException $ex) {
            throw ImageDecodeException::byImageUrl($imageUrl);
        }
    }
}
