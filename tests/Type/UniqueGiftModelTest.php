<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Sticker\Sticker;
use Phptg\BotApi\Type\UniqueGiftModel;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class UniqueGiftModelTest extends TestCase
{
    public function testBase(): void
    {
        $sticker = new Sticker('stickerId', 'uniqueStickerId', 'unique', 100, 120, false, true);
        $model = new UniqueGiftModel('modelId', $sticker, 500);

        assertSame('modelId', $model->name);
        assertSame($sticker, $model->sticker);
        assertSame(500, $model->rarityPerMille);
    }

    public function testFromTelegramResult(): void
    {
        $model = (new ObjectFactory())->create([
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
        ], null, UniqueGiftModel::class);

        assertInstanceOf(UniqueGiftModel::class, $model);
        assertSame('modelId', $model->name);
        assertSame('stickerId', $model->sticker->fileId);
        assertSame(500, $model->rarityPerMille);
    }
}
