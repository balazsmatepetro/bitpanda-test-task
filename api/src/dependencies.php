<?php

use App\Contract\Repository\CurrencyRepositoryInterface;
use App\Contract\Service\DecodeImageService;
use App\Http\Controller\CurrencyController;
use App\Http\Controller\CurrencyListController;
use App\Repository\CoinMarketApiCurrencyRepository;
use App\Service\Base64DecodeRemoteImageService;
use GuzzleHttp\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Slim\App;
use Slim\Container;
use Slim\Views\PhpRenderer;

return function (App $app) {
    $container = $app->getContainer();

    $container[DecodeImageService::class] = function () {
        return new Base64DecodeRemoteImageService(new Client);
    };

    $container[CurrencyRepositoryInterface::class] = function (Container $container) {
        return new CoinMarketApiCurrencyRepository($container->get('coin_market_api_client'));
    };

    $container[CurrencyController::class] = function (Container $container) {
        return new CurrencyController(
            $container->get(CurrencyRepositoryInterface::class),
            $container->get(DecodeImageService::class)
        );
    };

    $container[CurrencyListController::class] = function (Container $container) {
        return new CurrencyListController($container->get(CurrencyRepositoryInterface::class));
    };

    $container['coin_market_api_client'] = function () {
        return new Client([
            'base_uri' => getenv('COIN_MARKET_API_URL'),
            'headers' => [
                'Accepts:' => 'application/json',
                'X-CMC_PRO_API_KEY' => getenv('COIN_MARKET_API_KEY')
            ]
        ]);
    };

    // view renderer
    $container['renderer'] = function (Container $container) {
        $settings = $container->get('settings')['renderer'];

        return new PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function (Container $container) {
        $settings = $container->get('settings')['logger'];

        $logger = new Logger($settings['name']);
        $logger->pushProcessor(new UidProcessor());
        $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));

        return $logger;
    };
};
