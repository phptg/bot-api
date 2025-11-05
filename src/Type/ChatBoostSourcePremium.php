<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatboostsourcepremium
 *
 * @api
 */
final readonly class ChatBoostSourcePremium implements ChatBoostSource
{
    public function __construct(
        public User $user,
    ) {}

    public function getSource(): string
    {
        return 'premium';
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
