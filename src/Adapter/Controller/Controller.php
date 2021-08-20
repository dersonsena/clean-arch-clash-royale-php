<?php

namespace App\Adapter\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

interface Controller
{
    public function handle(Request $request, Response $response, array $args = []): Response;
}