<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatShareThemeUniqueGift;
use Phptg\BotApi\Type\Sticker\Sticker;
use Phptg\BotApi\Type\UniqueGift;
use Phptg\BotApi\Type\UniqueGiftBackdrop;
use Phptg\BotApi\Type\UniqueGiftBackdropColors;
use Phptg\BotApi\Type\UniqueGiftModel;
use Phptg\BotApi\Type\UniqueGiftSymbol;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class ChatShareThemeUniqueGiftTest extends TestCase
{
    public function testBase(): void
    {
        $gift = new UniqueGift(
            'gift-id-456',
            'baseName',
            'uniqueName',
            1,
            new UniqueGiftModel(
                'id1',
                new Sticker(
                    'x1',
                    'fullX1',
                    'unique',
                    100,
                    120,
                    false,
                    true,
                ),
                200,
            ),
            new UniqueGiftSymbol(
                'id2',
                new Sticker(
                    'x1',
                    'fullX1',
                    'unique',
                    100,
                    120,
                    false,
                    true,
                ),
                200,
            ),
            new UniqueGiftBackdrop(
                'id3',
                new UniqueGiftBackdropColors(1, 2, 3, 4),
                200,
            ),
        );
        $chatShareTheme = new ChatShareThemeUniqueGift($gift);

        assertSame('unique_gift', $chatShareTheme->getType());
        assertSame($gift, $chatShareTheme->gift);
    }

    public function testFromTelegramResult(): void
    {
        $chatShareTheme = (new ObjectFactory())->create([
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
        ], null, ChatShareThemeUniqueGift::class);

        assertInstanceOf(ChatShareThemeUniqueGift::class, $chatShareTheme);
        assertSame('BaseName', $chatShareTheme->gift->baseName);
        assertSame(1, $chatShareTheme->gift->number);
    }
}
