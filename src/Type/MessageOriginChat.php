<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#messageoriginchat
 *
 * @api
 */
final readonly class MessageOriginChat implements MessageOrigin
{
    public function __construct(
        public DateTimeImmutable $date,
        public Chat $senderChat,
        public ?string $authorSignature = null,
    ) {}

    public function getType(): string
    {
        return 'chat';
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
