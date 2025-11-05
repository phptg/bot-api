<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\ParseResult\ObjectFactory;

/**
 * @template TValue
 * @template-implements ValueProcessorInterface<TValue>
 *
 * @api
 */
final readonly class RawValue implements ValueProcessorInterface
{
    /**
     * @psalm-param TValue $value
     */
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): mixed
    {
        return $value;
    }
}
