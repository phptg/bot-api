<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\MessageAutoDeleteTimerChanged;

use function PHPUnit\Framework\assertSame;

final class MessageAutoDeleteTimerChangedTest extends TestCase
{
    public function testBase(): void
    {
        $messageAutoDeleteTimerChanged = new MessageAutoDeleteTimerChanged(12);

        assertSame(12, $messageAutoDeleteTimerChanged->messageAutoDeleteTime);
    }

    public function testFromTelegramResult(): void
    {
        $messageAutoDeleteTimerChanged = (new ObjectFactory())->create([
            'message_auto_delete_time' => 12,
        ], null, MessageAutoDeleteTimerChanged::class);

        assertSame(12, $messageAutoDeleteTimerChanged->messageAutoDeleteTime);
    }
}
