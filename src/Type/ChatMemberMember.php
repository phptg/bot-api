<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#chatmembermember
 *
 * @api
 */
final readonly class ChatMemberMember implements ChatMember
{
    public function __construct(
        public User $user,
        public ?DateTimeImmutable $untilDate = null,
        public ?string $tag = null,
    ) {}

    public function getStatus(): string
    {
        return 'member';
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
