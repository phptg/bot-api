<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatmemberleft
 *
 * @api
 */
final readonly class ChatMemberLeft implements ChatMember
{
    public function __construct(
        public User $user,
    ) {}

    public function getStatus(): string
    {
        return 'left';
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
