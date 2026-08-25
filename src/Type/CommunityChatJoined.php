<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#communitychatjoined
 *
 * @api
 */
final readonly class CommunityChatJoined
{
    public function __construct(
        public Community $community,
    ) {}
}
