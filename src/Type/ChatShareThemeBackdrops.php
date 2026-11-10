<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#chatsharethemebackdrops
 *
 * @api
 */
final readonly class ChatShareThemeBackdrops
{
    /**
     * @param ChatShareThemeBackdrop[] $backdrops
     */
    public function __construct(
        #[ArrayOfObjectsValue(ChatShareThemeBackdrop::class)]
        public array $backdrops,
    ) {}
}
