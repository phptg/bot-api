<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#inaccessiblemessage
 *
 * @api
 */
final readonly class InaccessibleMessage
{
    public function __construct(
        public Chat $chat,
        public int $messageId,
    ) {}
}
