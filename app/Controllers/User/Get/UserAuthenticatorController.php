<?php

declare(strict_types=1);

namespace App\Controllers\User\Get;

use User\Application\Bus\UserQuery;
use User\Domain\Repositories\UserRepository;
use User\Domain\Exceptions\PasswordDoesNotMatch;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use User\Application\Bus\UserAuthenticator\UserAuthenticationHandler;
use User\Domain\Exceptions\UserDoesNotExist;

final class UserAuthenticatorController
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $handler = new UserAuthenticationHandler($this->userRepository);
        $token = $handler->ask($this->bindParameters($request->getQueryParams()));
        $response->getBody()->write(
            json_encode([
                "token" => $token->token()
            ])
        );

        return $response;
    }

    private function bindParameters(array $payload): UserQuery
    {
        return new UserQuery(
            null,
            $payload["user-name"] ?? null,
            $payload["password"] ?? null
        );
    }
}
