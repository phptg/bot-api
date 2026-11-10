<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetUniqueGift;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\UniqueGift;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class GetUniqueGiftTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetUniqueGift('uniqueName');

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getUniqueGift', $method->getApiMethod());
        assertSame(['name' => 'uniqueName'], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetUniqueGift('uniqueName');

        $preparedResult = TestHelper::createSuccessStubApi([
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
        ])->call($method);

        assertInstanceOf(UniqueGift::class, $preparedResult);
        assertSame('gift-abc-123', $preparedResult->giftId);
        assertSame('uniqueName', $preparedResult->name);
    }
}
