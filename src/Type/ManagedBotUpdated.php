<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#managedbotupdated
 *
 * @api
 */
final readonly class ManagedBotUpdated
{
    public function __construct(
        public User $user,
        public User $bot,
    ) {}
}
