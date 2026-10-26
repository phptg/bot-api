<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult;

use Phptg\BotApi\ParseResult\ValueProcessor\ValueProcessorInterface;

/**
 * @internal
 */
final readonly class Param
{
    /**
     * @param class-string|ValueProcessorInterface<mixed> $type
     */
    public function __construct(
        public string $key,
        public string|ValueProcessorInterface $type,
        public bool $optional,
    ) {}
}
