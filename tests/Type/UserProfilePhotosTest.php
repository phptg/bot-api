<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\UserProfilePhotos;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

final class UserProfilePhotosTest extends TestCase
{
    public function testBase(): void
    {
        $userProfilePhotos = new UserProfilePhotos(5, []);

        assertSame(5, $userProfilePhotos->totalCount);
        assertSame([], $userProfilePhotos->photos);
    }

    public function testFromTelegramResult(): void
    {
        $userProfilePhotos = (new ObjectFactory())->create([
            'total_count' => 1,
            'photos' => [
                [
                    [
                        'file_id' => 'file_id_1',
                        'file_unique_id' => 'file_unique_id_1',
                        'width' => 100,
                        'height' => 200,
                        'file_size' => 300,
                    ],
                    [
                        'file_id' => 'file_id_2',
                        'file_unique_id' => 'file_unique_id_2',
                        'width' => 400,
                        'height' => 500,
                        'file_size' => 600,
                    ],
                ],
            ],
        ], null, UserProfilePhotos::class);

        assertSame(1, $userProfilePhotos->totalCount);

        assertCount(1, $userProfilePhotos->photos);
        assertCount(2, $userProfilePhotos->photos[0]);

        assertSame('file_id_1', $userProfilePhotos->photos[0][0]->fileId);
        assertSame('file_unique_id_1', $userProfilePhotos->photos[0][0]->fileUniqueId);
        assertSame(100, $userProfilePhotos->photos[0][0]->width);
        assertSame(200, $userProfilePhotos->photos[0][0]->height);
        assertSame(300, $userProfilePhotos->photos[0][0]->fileSize);

        assertSame('file_id_2', $userProfilePhotos->photos[0][1]->fileId);
        assertSame('file_unique_id_2', $userProfilePhotos->photos[0][1]->fileUniqueId);
        assertSame(400, $userProfilePhotos->photos[0][1]->width);
        assertSame(500, $userProfilePhotos->photos[0][1]->height);
        assertSame(600, $userProfilePhotos->photos[0][1]->fileSize);
    }
}
