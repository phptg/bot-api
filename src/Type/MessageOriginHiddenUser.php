<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#messageoriginhiddenuser
 *
 * @api
 */
final readonly class MessageOriginHiddenUser implements MessageOrigin
{
    public function __construct(
        public DateTimeImmutable $date,
        public string $senderUserName,
    ) {}

    public function getType(): string
    {
        return 'hidden_user';
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
