<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Attribute;
use DateTimeImmutable;
use Phptg\BotApi\ParseResult\InvalidTypeOfValueInResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;

use function is_int;

/**
 * @template-implements ValueProcessorInterface<DateTimeImmutable|false>
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final readonly class ChatMemberUntilDateValue implements ValueProcessorInterface
{
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): DateTimeImmutable|false
    {
        if (!is_int($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'integer');
        }

        return $value === 0
            ? false
            : (new DateTimeImmutable())->setTimestamp($value);
    }
}
