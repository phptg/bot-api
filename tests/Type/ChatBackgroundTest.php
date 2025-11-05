<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BackgroundTypeChatTheme;
use Phptg\BotApi\Type\ChatBackground;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class ChatBackgroundTest extends TestCase
{
    public function testBase(): void
    {
        $backgroundType = new BackgroundTypeChatTheme('dark');
        $chatBackground = new ChatBackground($backgroundType);

        assertSame($backgroundType, $chatBackground->type);
    }

    public function testFromTelegramResult(): void
    {
        $chatBackground = (new ObjectFactory())->create([
            'type' => [
                'type' => 'chat_theme',
                'theme_name' => 'dark',
            ],
        ], null, ChatBackground::class);

        assertInstanceOf(BackgroundTypeChatTheme::class, $chatBackground->type);
        assertSame('dark', $chatBackground->type->themeName);
        assertSame('chat_theme', $chatBackground->type->getType());
    }
}
