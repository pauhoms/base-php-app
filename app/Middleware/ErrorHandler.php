<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

final class ErrorHandler {
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        try {
            return $handler->handle($request);
        } catch (\TypeError $e) {
            $response = new \Slim\Psr7\Response(415);
            $response->getBody()->write(json_encode(
                [
                    'error_message' => 'Invalid parameters'
                ]
            ));

            return $response;
        }
    }
}
