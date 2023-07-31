<?php

declare(strict_types=1);

use Slim\App;
use Bonbast\Bonbast;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/price/{currency}', function (Request $request, Response $response) {
        $bonbast = new Bonbast();
        $data = $bonbast->get_formatted_price($request->getAttribute("currency")); // usd, eur ...
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);

        return $response;
    });
};
