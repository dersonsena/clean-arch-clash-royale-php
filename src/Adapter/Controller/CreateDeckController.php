<?php

declare(strict_types=1);

namespace App\Adapter\Controller;

use App\Domain\Repository\DeckRepository;
use App\Domain\Repository\PlayerRepository;
use App\Domain\UseCase\CreateDeck\CreateDeck;
use App\Domain\UseCase\CreateDeck\InputData;
use Exception;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class CreateDeckController implements Controller
{
    public function __construct(
        private PlayerRepository $playerRepo,
        private DeckRepository $deckRepo
    ) {}

    public function handle(Request $request, Response $response, array $args = []): Response
    {
        $useCase = new CreateDeck($this->playerRepo, $this->deckRepo);
        $bodyAsArray = json_decode($request->getBody()->getContents(), true);

        if (empty($bodyAsArray['cardIdList'])) {
            $response->withStatus(400);
            throw new Exception('Card Id List cannot be empty');
        }

        // Other request payload validation || validation in middlewares

        $inputData = InputData::create([
            'capacity' => (int)$bodyAsArray['capacity'],
            'playerId' => (int)$bodyAsArray['playerId'],
            'cardIdList' => $bodyAsArray['cardIdList']
        ]);

        $result = $useCase->execute($inputData);

        $responsePayload = json_encode([
            'id' => $result->id,
            'elixirAverage' => $result->elixirAverage,
            'player' => $result->player->name,
        ]);

        $response = $response->withHeader('Content-Type', 'application/json')
            ->withStatus(401);

        return $response;
    }
}