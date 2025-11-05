<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\ParseResult\InvalidTypeOfValueInResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;

use function is_string;

/**
 * @template-implements ValueProcessorInterface<string>
 */
final readonly class StringValue implements ValueProcessorInterface
{
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): string
    {
        if (!is_string($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'string');
        }
        return $value;
    }
}
