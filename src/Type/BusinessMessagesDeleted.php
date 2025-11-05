<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\IntegerValue;

/**
 * @see https://core.telegram.org/bots/api#businessmessagesdeleted
 *
 * @api
 */
final readonly class BusinessMessagesDeleted
{
    /**
     * @param int[] $messageIds
     */
    public function __construct(
        public string $businessConnectionId,
        public Chat $chat,
        #[ArrayMap(IntegerValue::class)]
        public array $messageIds,
    ) {}
}
