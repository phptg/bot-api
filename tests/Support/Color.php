<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Support;

final readonly class Color
{
    public function __construct(
        // @phpstan-ignore class.notFound, class.notFound (the class does not exist on purpose), shipmonk.deadProperty.neverRead (the fixture is only created by `ResultFactory`)
        public NotExists $type,
    ) {}
}
