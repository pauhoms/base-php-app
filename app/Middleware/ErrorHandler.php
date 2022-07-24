<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Shared\Infrastructure\Http\Exceptions\HttpException;
use TypeError;

final class ErrorHandler {
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        try {
            return $handler->handle($request);
        } catch (HttpException $e) {
            $response = new \Slim\Psr7\Response($e->httpCode);
            $response->getBody()->write(json_encode(
                [
                    'message' => $e->getMessage(),
                ]
            ));

            return $response;
        }
    }
}
