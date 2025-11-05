<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\IntegerValue;

/**
 * @see https://core.telegram.org/bots/api#pollanswer
 *
 * @api
 */
final readonly class PollAnswer
{
    /**
     * @param int[] $optionIds
     */
    public function __construct(
        public string $pollId,
        #[ArrayMap(IntegerValue::class)]
        public array $optionIds,
        public ?Chat $voterChat = null,
        public ?User $user = null,
    ) {}
}
