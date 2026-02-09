<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatownerchanged
 *
 * @api
 */
final readonly class ChatOwnerChanged
{
    public function __construct(
        public User $newOwner,
    ) {}
}
