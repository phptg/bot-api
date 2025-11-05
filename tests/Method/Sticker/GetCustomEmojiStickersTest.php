<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Sticker\GetCustomEmojiStickers;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\Sticker\Sticker;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertSame;

final class GetCustomEmojiStickersTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetCustomEmojiStickers(['id1']);

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getCustomEmojiStickers', $method->getApiMethod());
        assertSame(
            [
                'custom_emoji_ids' => ['id1'],
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetCustomEmojiStickers(['id1']);

        $preparedResult = TestHelper::createSuccessStubApi([
            [
                'file_id' => 'x1',
                'file_unique_id' => 'fullX1',
                'type' => 'regular',
                'width' => 100,
                'height' => 120,
                'is_animated' => false,
                'is_video' => true,
            ],
        ])->call($method);

        assertIsArray($preparedResult);
        assertCount(1, $preparedResult);
        assertInstanceOf(Sticker::class, $preparedResult[0]);
        assertSame('x1', $preparedResult[0]->fileId);
    }
}
