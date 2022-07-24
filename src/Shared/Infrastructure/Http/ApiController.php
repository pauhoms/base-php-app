<?php

namespace Shared\Infrastructure\Http;

use Error;
use Exception;
use Shared\Domain\Bus\Query;
use Shared\Domain\Bus\QueryHandler;
use Shared\Domain\Bus\QueryResponse;
use Shared\Infrastructure\Http\Exceptions\HttpException;

abstract class ApiController
{
    private const SHARED_EXCEPTIONS_MAPPING = [
       \TypeError::class => 415
    ];

    protected abstract function exceptionMapping(): array;

    /**
     * @param array|null $parameters
     * @param string $keyName
     * @param bool $hasNullable
     * @return mixed
     */
    protected static function assertParameter(?array $parameters, string $keyName, bool $hasNullable): mixed
    {
        if ($parameters === null && !$hasNullable) {
            throw new HttpException("Parameter $keyName doesnt exist in parameters", 415);
        }

        if ($parameters === null && $hasNullable) {
           return null;
        }

        if (!array_key_exists($keyName, $parameters) && $hasNullable) {
            return null;
        }

        if (!array_key_exists($keyName, $parameters) && !$hasNullable) {
            throw new HttpException("Parameter $keyName doesnt exist in parameters", 415);
        }

        return $parameters[$keyName];
    }

    protected function ask(QueryHandler $handler, Query $query): ?QueryResponse
    {
        try {
            return $handler->ask($query);
        } catch (Exception|Error $e) {
            $exceptions = array_merge($this->exceptionMapping(), self::SHARED_EXCEPTIONS_MAPPING);

            array_map(
                fn (string $exception, int $statusCode) => $this->throwHttpException($e, $exception, $statusCode),
                array_keys($exceptions),
                $exceptions
            );

            throw new HttpException($e->getMessage(), 500);
        }
    }

    private function throwHttpException(Exception|Error $error, string $exceptionClass, int $httpStatusCode): void
    {
        if ($error instanceof $exceptionClass) {
            throw new HttpException($error->getMessage(), $httpStatusCode);
        }
    }
}