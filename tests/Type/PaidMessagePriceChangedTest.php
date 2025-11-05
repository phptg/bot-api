<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\PaidMessagePriceChanged;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class PaidMessagePriceChangedTest extends TestCase
{
    public function testBase(): void
    {
        $object = new PaidMessagePriceChanged(23);

        assertSame(23, $object->paidMessageStarCount);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create([
            'paid_message_star_count' => 11,
        ], null, PaidMessagePriceChanged::class);

        assertInstanceOf(PaidMessagePriceChanged::class, $object);
        assertSame(11, $object->paidMessageStarCount);
    }
}
