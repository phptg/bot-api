<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#messagegenerationstopped
 *
 * @api
 */
final readonly class MessageGenerationStopped
{
    public function __construct(
        public Chat $chat,
        public int $draftId,
        public ?int $messageThreadId = null,
    ) {}
}
