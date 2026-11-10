<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\Type\EmojiType;
use Phptg\BotApi\Type\EmojiTypeCustomEmoji;
use Phptg\BotApi\Type\EmojiTypeEmoji;

/**
 * @template-extends InterfaceValue<EmojiType>
 */
final readonly class EmojiTypeValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'emoji' => EmojiTypeEmoji::class,
            'custom_emoji' => EmojiTypeCustomEmoji::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown emoji type.';
    }
}
