<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Support;

final readonly class Car
{
    public function __construct(
        // @phpstan-ignore shipmonk.deadProperty.neverRead (the fixture is only created by `ResultFactory`)
        public string|int $engine,
    ) {}
}
