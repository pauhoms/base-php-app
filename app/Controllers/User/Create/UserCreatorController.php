<?php

namespace App\Controllers\User\Create;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use User\Application\Bus\UserCreator\UserCreatorHandler;
use User\Application\Bus\UserQuery;
use User\Domain\Exceptions\UserDoesExist;
use User\Domain\Repositories\UserRepository;

final class UserCreatorController {
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $handler = new UserCreatorHandler($this->userRepository);
        try {
            $userResponse = $handler->ask($this->bindParameters($request->getParsedBody()));
            $response->getBody()->write(
                json_encode([
                    "id" => $userResponse->id()
                ])
            );
        } catch (UserDoesExist $e) {
            $response = $response->withStatus(409);
            $response->getBody()->write(
                json_encode([
                    "error-message" => $e->getMessage()
                ])
            );
        }

        return $response;
    }

    private function bindParameters(array $payload): UserQuery
    {
        return new UserQuery(
            null,
            isset($payload["user-name"]) ? $payload["user-name"]: null,
            isset($payload["password"]) ? $payload["password"]: null
        );
    }
}
