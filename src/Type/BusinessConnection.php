<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#businessconnection
 *
 * @api
 */
final readonly class BusinessConnection
{
    public function __construct(
        public string $id,
        public User $user,
        public int $userChatId,
        public DateTimeImmutable $date,
        public ?BusinessBotRights $rights,
        public bool $isEnabled,
    ) {}
}
