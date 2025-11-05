<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\DirectMessagePriceChanged;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class DirectMessagePriceChangedTest extends TestCase
{
    public function testBase(): void
    {
        $type = new DirectMessagePriceChanged(true);

        assertTrue($type->areDirectMessagesEnabled);
        assertNull($type->directMessageStarCount);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create(
            [
                'are_direct_messages_enabled' => false,
            ],
            null,
            DirectMessagePriceChanged::class,
        );

        assertFalse($type->areDirectMessagesEnabled);
        assertNull($type->directMessageStarCount);
    }

    public function testFromTelegramResultFull(): void
    {
        $type = (new ObjectFactory())->create(
            [
                'are_direct_messages_enabled' => true,
                'direct_message_star_count' => 7,
            ],
            null,
            DirectMessagePriceChanged::class,
        );

        assertTrue($type->areDirectMessagesEnabled);
        assertSame(7, $type->directMessageStarCount);
    }
}
