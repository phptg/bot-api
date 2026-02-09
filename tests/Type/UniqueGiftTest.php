<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\Sticker\Sticker;
use Phptg\BotApi\Type\UniqueGift;
use Phptg\BotApi\Type\UniqueGiftBackdrop;
use Phptg\BotApi\Type\UniqueGiftBackdropColors;
use Phptg\BotApi\Type\UniqueGiftColors;
use Phptg\BotApi\Type\UniqueGiftModel;
use Phptg\BotApi\Type\UniqueGiftSymbol;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class UniqueGiftTest extends TestCase
{
    public function testBase(): void
    {
        $model = new UniqueGiftModel(
            'modelId',
            new Sticker('stickerId', 'uniqueStickerId', 'unique', 100, 120, false, true),
            500,
        );
        $symbol = new UniqueGiftSymbol(
            'symbolId',
            new Sticker('stickerId', 'uniqueStickerId', 'unique', 100, 120, false, true),
            300,
        );
        $backdrop = new UniqueGiftBackdrop(
            'backdropId',
            new UniqueGiftBackdropColors(1, 2, 3, 4),
            200,
        );

        $type = new UniqueGift('gift123', 'baseName', 'uniqueName', 1, $model, $symbol, $backdrop);

        assertSame('gift123', $type->giftId);
        assertSame('baseName', $type->baseName);
        assertSame('uniqueName', $type->name);
        assertSame(1, $type->number);
        assertSame($model, $type->model);
        assertSame($symbol, $type->symbol);
        assertSame($backdrop, $type->backdrop);
        assertNull($type->isPremium);
        assertNull($type->isFromBlockchain);
        assertNull($type->colors);
        assertNull($type->publisherChat);
        assertNull($type->isBurned);
    }

    public function testFull(): void
    {
        $model = new UniqueGiftModel(
            'modelId',
            new Sticker('stickerId', 'uniqueStickerId', 'unique', 100, 120, false, true),
            500,
        );
        $symbol = new UniqueGiftSymbol(
            'symbolId',
            new Sticker('stickerId', 'uniqueStickerId', 'unique', 100, 120, false, true),
            300,
        );
        $backdrop = new UniqueGiftBackdrop(
            'backdropId',
            new UniqueGiftBackdropColors(1, 2, 3, 4),
            200,
        );
        $colors = new UniqueGiftColors(
            'model-emoji-123',
            'symbol-emoji-456',
            16733525,
            [13041721, 9473087],
            5773381,
            [16761600, 14349222],
        );
        $publisherChat = new Chat(789, 'channel');

        $type = new UniqueGift(
            'gift123',
            'baseName',
            'uniqueName',
            1,
            $model,
            $symbol,
            $backdrop,
            true,
            true,
            $colors,
            $publisherChat,
            true,
        );

        assertSame('gift123', $type->giftId);
        assertSame('baseName', $type->baseName);
        assertSame('uniqueName', $type->name);
        assertSame(1, $type->number);
        assertSame($model, $type->model);
        assertSame($symbol, $type->symbol);
        assertSame($backdrop, $type->backdrop);
        assertSame(true, $type->isPremium);
        assertSame(true, $type->isFromBlockchain);
        assertSame($colors, $type->colors);
        assertSame($publisherChat, $type->publisherChat);
        assertSame(true, $type->isBurned);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'gift_id' => 'gift-abc-123',
            'base_name' => 'BaseName',
            'name' => 'uniqueName',
            'number' => 1,
            'model' => [
                'name' => 'modelId',
                'sticker' => [
                    'file_id' => 'stickerId',
                    'file_unique_id' => 'uniqueStickerId',
                    'type' => 'unique',
                    'width' => 100,
                    'height' => 120,
                    'is_animated' => false,
                    'is_video' => true,
                ],
                'rarity_per_mille' => 500,
            ],
            'symbol' => [
                'name' => 'symbolId',
                'sticker' => [
                    'file_id' => 'stickerId',
                    'file_unique_id' => 'uniqueStickerId',
                    'type' => 'unique',
                    'width' => 100,
                    'height' => 120,
                    'is_animated' => false,
                    'is_video' => true,
                ],
                'rarity_per_mille' => 300,
            ],
            'backdrop' => [
                'name' => 'backdropId',
                'colors' => [
                    'center_color' => 1,
                    'edge_color' => 2,
                    'symbol_color' => 3,
                    'text_color' => 4,
                ],
                'rarity_per_mille' => 200,
            ],
            'is_premium' => true,
            'is_burned' => true,
            'is_from_blockchain' => true,
            'colors' => [
                'model_custom_emoji_id' => 'model-emoji-123',
                'symbol_custom_emoji_id' => 'symbol-emoji-456',
                'light_theme_main_color' => 16733525,
                'light_theme_other_colors' => [13041721, 9473087],
                'dark_theme_main_color' => 5773381,
                'dark_theme_other_colors' => [16761600, 14349222],
            ],
            'publisher_chat' => [
                'id' => 789,
                'type' => 'channel',
            ],
        ], null, UniqueGift::class);

        assertInstanceOf(UniqueGift::class, $type);
        assertSame('gift-abc-123', $type->giftId);
        assertSame('BaseName', $type->baseName);
        assertSame('uniqueName', $type->name);
        assertSame(1, $type->number);

        assertSame('modelId', $type->model->name);
        assertSame(500, $type->model->rarityPerMille);
        assertSame('stickerId', $type->model->sticker->fileId);

        assertSame('symbolId', $type->symbol->name);
        assertSame(300, $type->symbol->rarityPerMille);
        assertSame('stickerId', $type->symbol->sticker->fileId);

        assertSame('backdropId', $type->backdrop->name);
        assertSame(1, $type->backdrop->colors->centerColor);
        assertSame(200, $type->backdrop->rarityPerMille);
        assertSame(true, $type->isPremium);
        assertSame(true, $type->isFromBlockchain);
        assertInstanceOf(UniqueGiftColors::class, $type->colors);
        assertSame('model-emoji-123', $type->colors->modelCustomEmojiId);
        assertSame('symbol-emoji-456', $type->colors->symbolCustomEmojiId);
        assertSame(16733525, $type->colors->lightThemeMainColor);
        assertSame(789, $type->publisherChat?->id);
        assertSame(true, $type->isBurned);
    }
}
