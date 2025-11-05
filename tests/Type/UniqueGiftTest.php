<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Sticker\Sticker;
use Phptg\BotApi\Type\UniqueGift;
use Phptg\BotApi\Type\UniqueGiftBackdrop;
use Phptg\BotApi\Type\UniqueGiftBackdropColors;
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

        $type = new UniqueGift('baseName', 'uniqueName', 1, $model, $symbol, $backdrop);

        assertSame('baseName', $type->baseName);
        assertSame('uniqueName', $type->name);
        assertSame(1, $type->number);
        assertSame($model, $type->model);
        assertSame($symbol, $type->symbol);
        assertSame($backdrop, $type->backdrop);
        assertNull($type->publisherChat);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
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
            'publisher_chat' => [
                'id' => 789,
                'type' => 'channel',
            ],
        ], null, UniqueGift::class);

        assertInstanceOf(UniqueGift::class, $type);
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
        assertSame(789, $type->publisherChat?->id);
    }
}
