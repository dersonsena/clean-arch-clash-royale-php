<?php

use App\Adapter\Controller\CreateDeckController;
use App\Adapter\Repository\Memory\DeckRepositoryMemory;
use App\Adapter\Repository\Memory\PlayerMemoryRepository;
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

        /*$psr17Factory = new Psr17Factory();
        $requestBody = $psr17Factory->createStream(json_encode($request->all()));
        $requestPsr7 = $psr17Factory->createRequest('POST', "http://localhost:8081/{$request->getUrl()}")
            ->withHeader('Content-Type', 'application/json')
            ->withBody($requestBody);

        $responsePsr7 = $psr17Factory->createResponse(200);*/

        $requestPsr7 = new \GuzzleHttp\Psr7\Request(
            'POST',
            "http://localhost:8081/{$request->getUrl()}",
            ['Content-Type', "application/json"],
            json_encode($request->all())
        );

        $responsePsr7 = new Response();
        $result = $controller->handle($requestPsr7, $responsePsr7);

        echo $result->getBody()->getContents();
        die;
    });

    $route->post('/do-battle', function(\PlugRoute\Http\Request $request, \PlugRoute\Http\Response $response) {
        $deckRepo = new DeckRepositoryMemory();
        $controller = new App\Domain\UseCase\DoBattle\DoBattle($deckRepo);

        $psr17Factory = new Psr17Factory();
        $requestBody = $psr17Factory->createStream(json_encode($request->all()));
        $requestPsr7 = $psr17Factory->createRequest('POST', "http://localhost:8081/{$request->getUrl()}")
            ->withHeader('Content-Type', 'application/json')
            ->withBody($requestBody);

        $responsePsr7 = $psr17Factory->createResponse(200);

        return $controller->handle($requestPsr7, $responsePsr7);
    });
});

$route->on();