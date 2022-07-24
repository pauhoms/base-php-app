<?php

declare(strict_types=1);

namespace App\Controllers\User\Get;

use Shared\Infrastructure\Http\ApiController;
use User\Application\Bus\UserAuthenticator\UserAuthenticatorResponse;
use User\Application\Bus\UserQuery;
use User\Domain\Exceptions\PasswordDoesNotMatch;
use User\Domain\Exceptions\UserDoesNotExist;
use User\Domain\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use User\Application\Bus\UserAuthenticator\UserAuthenticationHandler;

final class UserAuthenticatorController extends ApiController
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $handler = new UserAuthenticationHandler($this->userRepository);

        /** @var UserAuthenticatorResponse $token */
        $token = $this->ask($handler, $this->bindParameters($request->getQueryParams()));

        $response->getBody()->write(
            json_encode([
                "token" => $token->token()
            ])
        );

        return $response;
    }

    private function bindParameters(?array $payload): UserQuery
    {
        return new UserQuery(
            null,
            self::assertParameter($payload, "user-name", false),
            self::assertParameter($payload, "password", false),
        );
    }

    protected function exceptionMapping(): array
    {
        return [
            UserDoesNotExist::class => 404,
            PasswordDoesNotMatch::class => 401
        ];
    }
}
