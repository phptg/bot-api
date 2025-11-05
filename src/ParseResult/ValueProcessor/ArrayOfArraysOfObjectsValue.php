<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Attribute;
use Phptg\BotApi\ParseResult\InvalidTypeOfValueInResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;

use function is_array;

/**
 * @template T
 * @template-implements ValueProcessorInterface<array<array-key,array<array-key,T>>>
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final readonly class ArrayOfArraysOfObjectsValue implements ValueProcessorInterface
{
    /**
     * @psalm-param class-string<T> $className
     */
    public function __construct(
        private string $className,
    ) {}

    /**
     * @psalm-return array<array-key,array<array-key,T>>
     */
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): mixed
    {
        if (!is_array($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'array[]');
        }

        foreach ($value as $v) {
            if (!is_array($v)) {
                throw new InvalidTypeOfValueInResultException($key, $v, 'array[]');
            }
        }

        return array_map(
            fn(array $array) => array_map(
                fn($item) => $objectFactory->create($item, $key, $this->className),
                $array,
            ),
            $value,
        );
    }
}
