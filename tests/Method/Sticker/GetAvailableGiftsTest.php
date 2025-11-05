<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Sticker\GetAvailableGifts;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

final class GetAvailableGiftsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetAvailableGifts();

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getAvailableGifts', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetAvailableGifts();

        $preparedResult = TestHelper::createSuccessStubApi([
            'gifts' => [
                [
                    'id' => 'test-id1',
                    'sticker' => [
                        'file_id' => 'x1',
                        'file_unique_id' => 'fullX1',
                        'type' => 'regular',
                        'width' => 100,
                        'height' => 120,
                        'is_animated' => false,
                        'is_video' => true,
                    ],
                    'star_count' => 11,
                ],
                [
                    'id' => 'test-id2',
                    'sticker' => [
                        'file_id' => 'x1',
                        'file_unique_id' => 'fullX1',
                        'type' => 'regular',
                        'width' => 100,
                        'height' => 120,
                        'is_animated' => false,
                        'is_video' => true,
                    ],
                    'star_count' => 11,
                ],
            ],
        ])->call($method);

        assertCount(2, $preparedResult->gifts);
    }
}
