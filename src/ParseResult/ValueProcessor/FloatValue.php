<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\ParseResult\InvalidTypeOfValueInResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;

use function is_float;

/**
 * @template-implements ValueProcessorInterface<float>
 */
final readonly class FloatValue implements ValueProcessorInterface
{
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): float
    {
        if (!is_float($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'float');
        }
        return $value;
    }
}
