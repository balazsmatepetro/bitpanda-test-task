<?php

namespace App\Http\Controller;

use App\Contract\Entity\CurrencyInterface;
use App\Contract\Repository\CurrencyRepositoryInterface;
use App\Contract\Service\DecodeImageService;
use App\Entity\Currency;
use App\Exception\CurrencyNotFoundException;
use App\Exception\ImageDecodeException;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Description of CurrencyController
 *
 * @package App\Http\Controller
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
class CurrencyController
{
    /**
     * The currency repository instance.
     *
     * @var CurrencyRepositoryInterface
     */
    private $currencyRepository;

    /**
     * The image decode service instance.
     *
     * @var DecodeImageService
     */
    private $decodeImageService;

    /**
     * CurrencyController constructor.
     *
     * @param CurrencyRepositoryInterface $currencyRepository
     * @param DecodeImageService $decodeImageService
     */
    public function __construct(
        CurrencyRepositoryInterface $currencyRepository,
        DecodeImageService $decodeImageService
    ) {
        $this->currencyRepository = $currencyRepository;
        $this->decodeImageService = $decodeImageService;
    }

    /**
     * Creates and returns the response.
     *
     * @param Request $request The request instance.
     * @param Response $response The resposne instance.
     * @return Response The created response.
     */
    public function execute(Request $request, Response $response): Response
    {
        try {
            $id = $request->getAttribute('id', 0);
            $currency = $this->currencyRepository->findById($id);

            // Currency is immutable, so we have to create a new instance.
            return $response->withJson(new Currency(
                $currency->getId(),
                $currency->getName(),
                $currency->getSymbol(),
                $currency->getDescription(),
                $this->decodeImage($currency),
                $currency->getDateAdded(),
                $currency->getLastUpdated()
            ));
        } catch (CurrencyNotFoundException $ex) {
            return $response->withJson($ex->getMessage(), 404);
        } catch (Exception $ex) {
            return $response->withJson('Unexpected server error!', 500);
        }
    }

    /**
     * Just simply executes the 'execute' method.
     *
     * @param Request $request The request instance.
     * @param Response $response The response instance.
     * @return Response The created response.
     */
    public function __invoke(Request $request, Response $response): Response
    {
        return $this->execute($request, $response);
    }

    /**
     * Decodes and returns the logo of the given currency. If the logo could not be decoded
     * returns an empty string.
     *
     * @param CurrencyInterface $currency The currency instance.
     * @return string The decoded content of the image or empty string.
     */
    private function decodeImage(CurrencyInterface $currency): string
    {
        try {
            return $this->decodeImageService->execute($currency->getLogo());
        } catch (ImageDecodeException $ex) {
            return '';
        }
    }
}
