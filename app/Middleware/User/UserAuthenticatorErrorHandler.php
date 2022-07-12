<?php

namespace App\Middleware\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use User\Domain\Exceptions\PasswordDoesNotMatch;
use User\Domain\Exceptions\UserDoesNotExist;

class UserAuthenticatorErrorHandler
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        try {
            return $handler->handle($request);
        } catch (UserDoesNotExist $e) {
            $response = new \Slim\Psr7\Response((404));
            $response->getBody()->write(
                json_encode([
                    "error-message" => $e->getMessage()
                ])
            );
            return $response;
        } catch (PasswordDoesNotMatch $e) {
            $response = new \Slim\Psr7\Response((401));
            $response->getBody()->write(
                json_encode([
                    "error-message" => $e->getMessage()
                ])
            );

            return $response;
        }
    }
}