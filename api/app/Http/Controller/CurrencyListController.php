<?php

namespace App\Http\Controller;

use App\Contract\Repository\CurrencyRepositoryInterface;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Description of CurrencyListController
 *
 * @package App\Http\Controller
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
class CurrencyListController
{
    /**
     * The currency repository instance.
     *
     * @var CurrencyRepositoryInterface
     */
    private $currencyRepository;

    /**
     * CurrencyListController constructor.
     *
     * @param CurrencyRepositoryInterface $currencyRepository
     */
    public function __construct(CurrencyRepositoryInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * Creates and returns the response.
     *
     * @param Request $request The request instance.
     * @param Response $response The response instance.
     * @return Response The created response.
     */
    public function execute(Request $request, Response $response): Response
    {
        try {
            return $response->withJson($this->currencyRepository->findAll());
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
}
