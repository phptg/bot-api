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
     * @psalm-param class-string|ValueProcessorInterface $type
     */
    public function __construct(
        public string $key,
        public string|ValueProcessorInterface $type,
        public bool $optional,
    ) {}
}
