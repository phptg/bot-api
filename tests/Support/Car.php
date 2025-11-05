<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Support;

final readonly class Car
{
    public function __construct(
        public string|int $engine,
    ) {}
}
