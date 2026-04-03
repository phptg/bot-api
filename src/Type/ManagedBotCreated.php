<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#managedbotcreated
 *
 * @api
 */
final readonly class ManagedBotCreated
{
    public function __construct(
        public User $bot,
    ) {}
}
