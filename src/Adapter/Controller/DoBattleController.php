<?php

declare(strict_types=1);

namespace App\Adapter\Controller;

use App\Domain\Repository\DeckRepository;
use App\Domain\UseCase\DoBattle\InputData;
use App\Domain\UseCase\DoBattle\DoBattle;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class DoBattleController implements Controller
{
    public function __construct(
        private DeckRepository $deckRepo
    ) {}

    public function handle(Request $request, Response $response, array $args = []): Response
    {
        $useCase = new DoBattle($this->deckRepo);
        $bodyAsArray = json_decode($request->getBody()->getContents(), true);

        // Request payload validation || validation in middlewares

        $inputData = InputData::create([
            'deckId1' => (int)$bodyAsArray['deckId1'],
            'deckId2' => (int)$bodyAsArray['deckId2']
        ]);

        $result = $useCase->execute($inputData);
        $responsePayload = json_encode([
            'winner' => ['name' => $result->winnerName, 'trophy' => $result->winnerTrophy],
            'loser' => ['name' => $result->loserName, 'trophy' => $result->loserTrophy],
        ]);

        $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200);

        $response->getBody()->write($responsePayload);

        return $response;
    }
}