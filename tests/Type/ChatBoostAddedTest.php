<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatBoostAdded;

use function PHPUnit\Framework\assertSame;

final class ChatBoostAddedTest extends TestCase
{
    public function testBase(): void
    {
        $chatBoostAdded = new ChatBoostAdded(4);

        assertSame(4, $chatBoostAdded->boostCount);
    }

    public function testFromTelegramResult(): void
    {
        $chatBoostAdded = (new ObjectFactory())->create([
            'boost_count' => 4,
        ], null, ChatBoostAdded::class);

        assertSame(4, $chatBoostAdded->boostCount);
    }
}
