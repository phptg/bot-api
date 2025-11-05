<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\PaidMediaInfo;
use Phptg\BotApi\Type\PaidMediaPhoto;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;

final class PaidMediaInfoTest extends TestCase
{
    public function testBase(): void
    {
        $photo = new PaidMediaPhoto([]);
        $type = new PaidMediaInfo(1, [$photo]);

        assertSame(1, $type->starCount);
        assertSame([$photo], $type->paidMedia);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'star_count' => 1,
            'paid_media' => [
                [
                    'type' => 'photo',
                    'photo' => [],
                ],
            ],
        ], null, PaidMediaInfo::class);

        assertSame(1, $type->starCount);
        assertEquals([new PaidMediaPhoto([])], $type->paidMedia);
    }
}
