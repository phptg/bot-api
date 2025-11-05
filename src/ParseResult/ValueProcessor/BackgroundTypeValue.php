<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\Type\BackgroundType;
use Phptg\BotApi\Type\BackgroundTypeChatTheme;
use Phptg\BotApi\Type\BackgroundTypeFill;
use Phptg\BotApi\Type\BackgroundTypePattern;
use Phptg\BotApi\Type\BackgroundTypeWallpaper;

/**
 * @template-extends InterfaceValue<BackgroundType>
 */
final readonly class BackgroundTypeValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'fill' => BackgroundTypeFill::class,
            'wallpaper' => BackgroundTypeWallpaper::class,
            'pattern' => BackgroundTypePattern::class,
            'chat_theme' => BackgroundTypeChatTheme::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown background type.';
    }
}
