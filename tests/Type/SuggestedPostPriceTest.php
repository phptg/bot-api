<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\SuggestedPostPrice;

use function PHPUnit\Framework\assertSame;

final class SuggestedPostPriceTest extends TestCase
{
    public function testBase(): void
    {
        $price = new SuggestedPostPrice('XTR', 50);

        assertSame('XTR', $price->currency);
        assertSame(50, $price->amount);
        assertSame(
            [
                'currency' => 'XTR',
                'amount' => 50,
            ],
            $price->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $price = (new ObjectFactory())->create(
            [
                'currency' => 'TON',
                'amount' => 10000000,
            ],
            null,
            SuggestedPostPrice::class,
        );

        assertSame('TON', $price->currency);
        assertSame(10000000, $price->amount);
    }
}
