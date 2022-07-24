<?php

declare(strict_types=1);

namespace App\Controllers\User\Create;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Shared\Infrastructure\Http\ApiController;
use User\Application\Bus\UserCreator\UserCreatorHandler;
use User\Application\Bus\UserCreator\UserCreatorQueryResponse;
use User\Application\Bus\UserQuery;
use User\Domain\Exceptions\UserDoesExist;
use User\Domain\Repositories\UserRepository;

final class UserCreatorController extends ApiController {
    public function __construct(private readonly UserRepository $userRepository) {}

    public function __invoke(Request $request, Response $response): Response
    {
        $handler = new UserCreatorHandler($this->userRepository);

        /** @var UserCreatorQueryResponse $userResponse */
        $userResponse = $this->ask($handler, $this->bindParameters($request->getParsedBody()));

        $response->getBody()->write(
            json_encode([
                "id" => $userResponse->id()
            ])
        );

        return $response;
    }

    protected function exceptionMapping(): array
    {
        return [
            UserDoesExist::class => 409,
        ];
    }

    private function bindParameters(?array $payload): UserQuery
    {
        return new UserQuery(
            null,
            (string) self::assertParameter($payload, "user-name", false),
            (string) self::assertParameter($payload, "password", false),
        );
    }
}
