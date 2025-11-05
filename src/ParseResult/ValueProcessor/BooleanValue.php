<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\ParseResult\InvalidTypeOfValueInResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;

use function is_bool;

/**
 * @template-implements ValueProcessorInterface<bool>
 */
final readonly class BooleanValue implements ValueProcessorInterface
{
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): bool
    {
        if (!is_bool($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'boolean');
        }
        return $value;
    }
}
