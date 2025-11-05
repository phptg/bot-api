<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetForumTopicIconStickers;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\Sticker\Sticker;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertSame;

final class GetForumTopicIconStickersTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetForumTopicIconStickers();

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getForumTopicIconStickers', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetForumTopicIconStickers();

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
