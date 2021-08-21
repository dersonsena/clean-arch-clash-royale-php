<?php

declare(strict_types=1);

namespace App\Infra\Http;

use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use PlugRoute\Http\Request;
use PlugRoute\Http\Response;
use Psr\Http\Message\RequestInterface as RequestPsr;
use Psr\Http\Message\ResponseInterface as ResponsePsr;

final class PlugRoutePsrAdapter
{
    public static function adaptRequest(Request $request): RequestPsr
    {
        return new GuzzleRequest(
            $request->method(),
            "http://localhost:8081/{$request->getUrl()}",
            ['Content-Type', "application/json"],
            json_encode($request->all())
        );
    }

    public static function adaptResponse(Response $response): ResponsePsr
    {
        return new GuzzleResponse();
    }
}