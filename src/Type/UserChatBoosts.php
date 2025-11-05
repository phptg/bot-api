<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#userchatboosts
 *
 * @api
 */
final readonly class UserChatBoosts
{
    /**
     * @param ChatBoost[] $boosts
     */
    public function __construct(
        #[ArrayOfObjectsValue(ChatBoost::class)]
        public array $boosts,
    ) {}
}
