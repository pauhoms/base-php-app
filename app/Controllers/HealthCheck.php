<?php


namespace App\Controllers;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HealthCheck
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $this->entityManager->getConnection()->connect();

        $json = [
            "mariadb" => $this->entityManager->getConnection()->isConnected()
        ];

        $response->getBody()->write(json_encode($json));

        return $response
            ->withStatus(200)
            ->withHeader('Content-type', 'application/json');
    }
}