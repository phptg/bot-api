<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\Type\ChatShareTheme;
use Phptg\BotApi\Type\ChatShareThemeEmoji;
use Phptg\BotApi\Type\ChatShareThemeUniqueGift;

/**
 * @template-extends InterfaceValue<ChatShareTheme>
 */
final readonly class ChatShareThemeValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'emoji' => ChatShareThemeEmoji::class,
            'unique_gift' => ChatShareThemeUniqueGift::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown chat share theme type.';
    }
}
