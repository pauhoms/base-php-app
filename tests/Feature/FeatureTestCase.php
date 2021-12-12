<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request as SlimRequest;
use Slim\Psr7\Uri;

abstract class FeatureTestCase extends TestCase
{
    protected function getAppInstance(): App
    {
        return require __DIR__ . '/../../app/bootstrap.php';
    }

    protected function createRequest(
        string $method,
        string $path,
        ?array $body = null,
        ?array $parameters = null,
        array $headers = ['HTTP_ACCEPT' => 'application/json'],
        array $cookies = [],
        array $serverParams = []
    ): ResponseInterface
    {
        $uri = new Uri('', '', 8081, $path);
        $handle = fopen('php://temp', 'w+');
        $stream = (new StreamFactory())->createStreamFromResource($handle);

        $h = new Headers();
        foreach ($headers as $name => $value) {
            $h->addHeader($name, $value);
        }

        $request = new SlimRequest($method, $uri, $h, $cookies, $serverParams, $stream);

        if ($parameters !== null)
            $request = $request->withQueryParams($parameters);

        if ($body !== null)
            $request = $request->withParsedBody($body);

        return $this->getAppInstance()->handle($request);
    }

    public function getResponseResult(ResponseInterface $response): array
    {
        return json_decode((string)$response->getBody(), true);
    }
}