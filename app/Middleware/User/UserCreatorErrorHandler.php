<?php

declare(strict_types=1);

namespace App\Middleware\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use User\Domain\Exceptions\UserDoesExist;

class UserCreatorErrorHandler
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        try {
            return $handler->handle($request);
        } catch (UserDoesExist $e) {
            $response = new \Slim\Psr7\Response((409));
            $response->getBody()->write(
                json_encode([
                    "error-message" => $e->getMessage()
                ])
            );

            return $response;
        }
    }
}
