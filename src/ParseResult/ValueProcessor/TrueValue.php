<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\ParseResult\InvalidTypeOfValueInResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;

/**
 * @template-implements ValueProcessorInterface<true>
 */
final readonly class TrueValue implements ValueProcessorInterface
{
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): true
    {
        if ($value !== true) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'true');
        }
        return $value;
    }
}
