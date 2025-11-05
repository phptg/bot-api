<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ValueProcessor\BackgroundTypeValue;
use Phptg\BotApi\Type\BackgroundTypeChatTheme;
use Phptg\BotApi\Type\BackgroundTypeFill;
use Phptg\BotApi\Type\BackgroundTypePattern;
use Phptg\BotApi\Type\BackgroundTypeWallpaper;

use function PHPUnit\Framework\assertInstanceOf;

final class BackgroundTypeValueTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                BackgroundTypeFill::class,
                [
                    'type' => 'fill',
                    'fill' => [
                        'type' => 'solid',
                        'color' => 0x000000,
                    ],
                    'dark_theme_dimming' => 95,
                ],
            ],
            [
                BackgroundTypeWallpaper::class,
                [
                    'type' => 'wallpaper',
                    'document' => [
                        'file_id' => 'f123',
                        'file_unique_id' => 'full123',
                    ],
                    'dark_theme_dimming' => 99,
                ],
            ],
            [
                BackgroundTypePattern::class,
                [
                    'type' => 'pattern',
                    'document' => [
                        'file_id' => 'f123',
                        'file_unique_id' => 'full123',
                    ],
                    'fill' => [
                        'type' => 'solid',
                        'color' => 0x000000,
                    ],
                    'intensity' => 5,
                ],
            ],
            [
                BackgroundTypeChatTheme::class,
                [
                    'type' => 'chat_theme',
                    'theme_name' => 'dark',
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedClass, array $data): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new BackgroundTypeValue();

        $result = $processor->process($data, null, $objectFactory);

        assertInstanceOf($expectedClass, $result);
    }

    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new BackgroundTypeValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown background type.');
        $processor->process(['type' => 'test'], null, $objectFactory);
    }
}
