<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatownerchanged
 *
 * Describes a service message about an ownership change in the chat.
 *
 * @api
 */
final readonly class ChatOwnerChanged
{
    public function __construct(
        public User $newOwner,
    ) {}
}
