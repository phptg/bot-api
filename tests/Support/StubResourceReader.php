<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Support;

use Phptg\BotApi\Transport\ResourceReader\ResourceReaderInterface;

final readonly class StubResourceReader implements ResourceReaderInterface
{
    public function __construct(
        private string $content = '',
        private string $uri = '',
        private bool $supports = true,
    ) {}

    public function read(mixed $resource): string
    {
        return $this->content;
    }

    public function getUri(mixed $resource): string
    {
        return $this->uri;
    }

    public function supports(mixed $resource): bool
    {
        return $this->supports;
    }
}
