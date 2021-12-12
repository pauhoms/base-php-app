<?php

namespace App\Controllers\User\Get;

use User\Application\Bus\UserQuery;
use User\Domain\Exceptions\UserDoesExist;
use User\Domain\Repositories\UserRepository;
use User\Domain\Exceptions\PasswordDoesNotMatch;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use User\Application\Bus\UserAuthenticator\UserAuthenticatiorHandler;

final class UserAuthenticatorController
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function __invoke(Request $request, Response $response): Response
    {
       // var_dump($request->getQueryParams());
        $handler = new UserAuthenticatiorHandler($this->userRepository);
        try {
            $token = $handler->ask($this->bindParameters($request->getQueryParams()));
            $response->getBody()->write(
                json_encode([
                    "token" => $token->token()
                ])
            );
        } catch (UserDoesExist $e) {
            $response = $response->withStatus(409);
            $response->getBody()->write(
                json_encode([
                    "error-message" => $e->getMessage()
                ])
            );
        } catch (PasswordDoesNotMatch $e) {
            $response = $response->withStatus(401);
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