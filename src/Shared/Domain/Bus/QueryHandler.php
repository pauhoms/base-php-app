<?php

namespace Shared\Domain\Bus;

interface QueryHandler
{
    public function ask($query): ?QueryResponse;
}