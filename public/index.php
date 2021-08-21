<?php

use App\Adapter\Controller\CreateDeckController;
use App\Adapter\Repository\Memory\DeckRepositoryMemory;
use App\Adapter\Repository\Memory\PlayerMemoryRepository;
use App\Infra\Http\PlugRoutePsrAdapter;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Nyholm\Psr7\Factory\Psr17Factory;

error_reporting(E_ALL ^ E_DEPRECATED);

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../vendor/autoload.php';

$route = \PlugRoute\RouteFactory::create();

$route->group(['prefix' => '/api'], function ($route) {
    $route->post('/create-deck', function(\PlugRoute\Http\Request $request, \PlugRoute\Http\Response $response) {
        $playerRepo = new PlayerMemoryRepository();
        $deckRepo = new DeckRepositoryMemory();
        $controller = new CreateDeckController($playerRepo, $deckRepo);

        $requestPsr = PlugRoutePsrAdapter::adaptRequest($request);
        $responsePsr = PlugRoutePsrAdapter::adaptResponse($response);

        $controllerResponse = $controller->handle($requestPsr, $responsePsr);
        $responseAsArray = json_decode($controllerResponse->getBody(), true);

        $response->setStatusCode($controllerResponse->getStatusCode())
            ->addHeaders($controllerResponse->getHeaders());

        echo $response->json($responseAsArray);
    });

    $route->post('/do-battle', function(\PlugRoute\Http\Request $request, \PlugRoute\Http\Response $response) {
        $deckRepo = new DeckRepositoryMemory();
        $controller = new \App\Adapter\Controller\DoBattleController($deckRepo);

        $requestPsr = PlugRoutePsrAdapter::adaptRequest($request);
        $responsePsr = PlugRoutePsrAdapter::adaptResponse($response);

        $controllerResponse = $controller->handle($requestPsr, $responsePsr);
        $responseAsArray = json_decode($controllerResponse->getBody(), true);

        $response->setStatusCode($controllerResponse->getStatusCode())
            ->addHeaders($controllerResponse->getHeaders());

        echo $response->json($responseAsArray);
    });
});

$route->on();