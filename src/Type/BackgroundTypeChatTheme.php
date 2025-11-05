<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#backgroundtypechattheme
 *
 * @api
 */
final readonly class BackgroundTypeChatTheme implements BackgroundType
{
    public function __construct(
        public string $themeName,
    ) {}

    public function getType(): string
    {
        return 'chat_theme';
    }
}
