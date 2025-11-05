<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\VideoChatEnded;

use function PHPUnit\Framework\assertSame;

final class VideoChatEndedTest extends TestCase
{
    public function testBase(): void
    {
        $videoChatEnded = new VideoChatEnded(12);

        assertSame(12, $videoChatEnded->duration);
    }

    public function testFromTelegramResult(): void
    {
        $videoChatEnded = (new ObjectFactory())->create([
            'duration' => 12,
        ], null, VideoChatEnded::class);

        assertSame(12, $videoChatEnded->duration);
    }
}
