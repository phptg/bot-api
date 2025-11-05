<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Attribute;
use Phptg\BotApi\ParseResult\InvalidTypeOfValueInResultException;
use Phptg\BotApi\ParseResult\NotFoundKeyInResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\InaccessibleMessage;
use Phptg\BotApi\Type\Message;

use function is_array;
use function is_int;

/**
 * @template-implements ValueProcessorInterface<InaccessibleMessage|Message>
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final readonly class MaybeInaccessibleMessageValue implements ValueProcessorInterface
{
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): mixed
    {
        if (!is_array($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'array');
        }

        $date = $value['date'] ?? null;
        if ($date === null) {
            throw new NotFoundKeyInResultException('date');
        }
        if (!is_int($date)) {
            throw new InvalidTypeOfValueInResultException('date', $date, 'integer');
        }

        return $date === 0
            ? $objectFactory->create($value, $key, InaccessibleMessage::class)
            : $objectFactory->create($value, $key, Message::class);
    }
}
