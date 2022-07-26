<?php

namespace Shared\Domain\Bus;

abstract class DomainSubscriber
{
    abstract function eventName(): string;
    abstract function origin(): string;
    public abstract function execute(array $body): void;
}
