<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatsharethemebackdrop
 *
 * @api
 */
final readonly class ChatShareThemeBackdrop
{
    public function __construct(
        public int $id,
        public string $name,
        public UniqueGiftBackdropColors $colors,
    ) {}
}
