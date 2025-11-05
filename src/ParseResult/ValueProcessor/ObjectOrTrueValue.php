<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\ParseResult\ObjectFactory;

/**
 * @template T
 * @template-implements ValueProcessorInterface<T|true>
 */
final readonly class ObjectOrTrueValue implements ValueProcessorInterface
{
    /**
     * @psalm-param class-string<T> $className
     */
    public function __construct(
        private string $className,
    ) {}

    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): mixed
    {
        return $value === true
            ? $value
            : $objectFactory->create($value, $key, $this->className);
    }
}
