<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\IntegerValue;
use Phptg\BotApi\ParseResult\ValueProcessor\StringValue;

/**
 * @see https://core.telegram.org/bots/api#pollanswer
 *
 * @api
 */
final readonly class PollAnswer
{
    /**
     * @param int[] $optionIds
     * @param string[] $optionPersistentIds
     */
    public function __construct(
        public string $pollId,
        #[ArrayMap(IntegerValue::class)]
        public array $optionIds,
        #[ArrayMap(StringValue::class)]
        public array $optionPersistentIds,
        public ?Chat $voterChat = null,
        public ?User $user = null,
    ) {}
}
