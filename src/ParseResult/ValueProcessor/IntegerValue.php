<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\ParseResult\InvalidTypeOfValueInResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;

use function is_int;

/**
 * @template-implements ValueProcessorInterface<int>
 */
final readonly class IntegerValue implements ValueProcessorInterface
{
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): int
    {
        if (!is_int($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'integer');
        }
        return $value;
    }
}
