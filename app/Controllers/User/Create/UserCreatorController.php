<?php

namespace App\Controllers\User\Create;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use User\Application\Bus\UserCreatorHandler;
use User\Application\Bus\UserQuery;
use User\Domain\Repositories\UserRepository;

final class UserCreatorController {
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $handler = new UserCreatorHandler($this->userRepository);
        $userResponse = $handler->ask($this->bindParameters($request->getParsedBody()));

        $response->getBody()->write(
            json_encode([
                "id" => $userResponse->id()
            ])
        );

        return $response;
    }

    private function bindParameters(array $payload): UserQuery
    {
        return new UserQuery(null, $payload["name"], $payload["password"]);
    }
}
