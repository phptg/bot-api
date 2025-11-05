<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\MessageId;

use function PHPUnit\Framework\assertSame;

final class MessageIdTest extends TestCase
{
    public function testBase(): void
    {
        $type = new MessageId(23);

        assertSame(23, $type->messageId);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create(['message_id' => 23], null, MessageId::class);

        assertSame(23, $type->messageId);
    }
}
