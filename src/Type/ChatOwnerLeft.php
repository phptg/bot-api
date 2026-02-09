<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatownerleft
 *
 * @api
 */
final readonly class ChatOwnerLeft
{
    public function __construct(
        public ?User $newOwner = null,
    ) {}
}
