<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\VideoChatScheduled;

use function PHPUnit\Framework\assertSame;

final class VideoChatScheduledTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $videoChatScheduled = new VideoChatScheduled($date);

        assertSame($date, $videoChatScheduled->startDate);
    }

    public function testFromTelegramResult(): void
    {
        $videoChatScheduled = (new ObjectFactory())->create([
            'start_date' => 1234567890,
        ], null, VideoChatScheduled::class);

        assertSame(1234567890, $videoChatScheduled->startDate->getTimestamp());
    }
}
