<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BusinessIntro;
use Phptg\BotApi\Type\Sticker\Sticker;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class BusinessIntroTest extends TestCase
{
    public function testBase(): void
    {
        $businessIntro = new BusinessIntro();

        assertNull($businessIntro->title);
        assertNull($businessIntro->message);
        assertNull($businessIntro->sticker);
    }

    public function testFromTelegramResult(): void
    {
        $businessIntro = (new ObjectFactory())->create([
            'title' => 'title1',
            'message' => 'message1',
            'sticker' => [
                'file_id' => 'file_id1',
                'file_unique_id' => 'file_unique_id1',
                'type' => 'regular',
                'width' => 23,
                'height' => 42,
                'is_animated' => true,
                'is_video' => false,
            ],
        ], null, BusinessIntro::class);

        assertSame('title1', $businessIntro->title);
        assertSame('message1', $businessIntro->message);

        assertInstanceOf(Sticker::class, $businessIntro->sticker);
        assertSame('file_id1', $businessIntro->sticker->fileId);
    }
}
