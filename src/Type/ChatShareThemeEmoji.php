<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\EmojiTypeValue;

/**
 * @see https://core.telegram.org/bots/api#chatsharethemeemoji
 *
 * @api
 */
final readonly class ChatShareThemeEmoji implements ChatShareTheme
{
    /**
     * @param EmojiType[] $emojis
     */
    public function __construct(
        #[ArrayMap(EmojiTypeValue::class)]
        public array $emojis,
        public ?int $backgroundBackdropId = null,
    ) {}

    public function getType(): string
    {
        return 'emoji';
    }
}
