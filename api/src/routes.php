<?php

use App\Http\Controller\CurrencyController;
use App\Http\Controller\CurrencyListController;
use Slim\App;

return function (App $app) {
    $app->group('/v1', function () use ($app) {
        $app->get('/currencies', CurrencyListController::class);
        $app->get('/currencies/{id}', CurrencyController::class);
    });
};
