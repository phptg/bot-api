<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ValueProcessor\ChatShareThemeValue;
use Phptg\BotApi\Type\ChatShareThemeEmoji;
use Phptg\BotApi\Type\ChatShareThemeUniqueGift;
use Phptg\BotApi\Type\EmojiTypeEmoji;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class ChatShareThemeValueTest extends TestCase
{
    public function testEmoji(): void
    {
        $result = (new ChatShareThemeValue())->process(
            [
                'type' => 'emoji',
                'emojis' => [
                    ['type' => 'emoji', 'emoji' => '🎁'],
                ],
                'background_backdrop_id' => 123,
            ],
            null,
            new ObjectFactory(),
        );

        assertInstanceOf(ChatShareThemeEmoji::class, $result);
        assertInstanceOf(EmojiTypeEmoji::class, $result->emojis[0]);
        assertSame('🎁', $result->emojis[0]->emoji);
        assertSame(123, $result->backgroundBackdropId);
    }

    public function testUniqueGift(): void
    {
        $result = (new ChatShareThemeValue())->process(
            [
                'type' => 'unique_gift',
                'gift' => [
                    'gift_id' => 'gift-unique-xyz',
                    'base_name' => 'BaseName',
                    'name' => 'uniqueName',
                    'number' => 1,
                    'model' => [
                        'name' => 'test1',
                        'sticker' => [
                            'file_id' => 'x1',
                            'file_unique_id' => 'fullX1',
                            'type' => 'unique',
                            'width' => 100,
                            'height' => 120,
                            'is_animated' => false,
                            'is_video' => true,
                        ],
                        'rarity_per_mille' => 200,
                    ],
                    'symbol' => [
                        'name' => 'test2',
                        'sticker' => [
                            'file_id' => 'x1',
                            'file_unique_id' => 'fullX1',
                            'type' => 'unique',
                            'width' => 100,
                            'height' => 120,
                            'is_animated' => false,
                            'is_video' => true,
                        ],
                        'rarity_per_mille' => 200,
                    ],
                    'backdrop' => [
                        'name' => 'test3',
                        'colors' => [
                            'center_color' => 1,
                            'edge_color' => 2,
                            'symbol_color' => 3,
                            'text_color' => 4,
                        ],
                        'rarity_per_mille' => 200,
                    ],
                ],
            ],
            null,
            new ObjectFactory(),
        );

        assertInstanceOf(ChatShareThemeUniqueGift::class, $result);
        assertSame('BaseName', $result->gift->baseName);
        assertSame(1, $result->gift->number);
    }

    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new ChatShareThemeValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown chat share theme type.');
        $processor->process(['type' => 'test'], null, $objectFactory);
    }
}
