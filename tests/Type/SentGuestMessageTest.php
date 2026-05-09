<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\SentGuestMessage;

use function PHPUnit\Framework\assertSame;

final class SentGuestMessageTest extends TestCase
{
    public function testBase(): void
    {
        $type = new SentGuestMessage('inline_msg_123');

        assertSame('inline_msg_123', $type->inlineMessageId);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create(['inline_message_id' => 'inline_msg_456'], null, SentGuestMessage::class);

        assertSame('inline_msg_456', $type->inlineMessageId);
    }
}
