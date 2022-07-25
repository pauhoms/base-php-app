<?php

namespace Shared\Domain\Bus;

interface CommandHandler
{
    public function dispatch($command): void;
}
