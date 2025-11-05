<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetUserProfilePhotos;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

final class GetUserProfilePhotosTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetUserProfilePhotos(123);

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getUserProfilePhotos', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 123,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new GetUserProfilePhotos(
            123,
            1,
            2,
        );

        assertSame(
            [
                'user_id' => 123,
                'offset' => 1,
                'limit' => 2,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetUserProfilePhotos(123);

        $preparedResult = TestHelper::createSuccessStubApi([
            'total_count' => 1,
            'photos' => [
                [
                    [
                        'file_id' => 'file_id',
                        'file_unique_id' => 'file_unique_id',
                        'width' => 1,
                        'height' => 2,
                        'file_size' => 3,
                    ],
                ],
            ],
        ])->call($method);

        assertSame(1, $preparedResult->totalCount);
        assertCount(1, $preparedResult->photos);
        assertCount(1, $preparedResult->photos[0]);
        assertSame('file_id', $preparedResult->photos[0][0]->fileId);
        assertSame('file_unique_id', $preparedResult->photos[0][0]->fileUniqueId);
        assertSame(1, $preparedResult->photos[0][0]->width);
        assertSame(2, $preparedResult->photos[0][0]->height);
        assertSame(3, $preparedResult->photos[0][0]->fileSize);
    }
}
