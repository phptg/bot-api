<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#sentguestmessage
 *
 * @api
 */
final readonly class SentGuestMessage
{
    public function __construct(
        public string $inlineMessageId,
    ) {}
}
