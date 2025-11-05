<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\SuggestedPostInfo;
use Phptg\BotApi\Type\SuggestedPostPrice;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class SuggestedPostInfoTest extends TestCase
{
    public function testBase(): void
    {
        $info = new SuggestedPostInfo('pending');

        assertSame('pending', $info->state);
        assertNull($info->price);
        assertNull($info->sendDate);
    }

    public function testFull(): void
    {
        $price = new SuggestedPostPrice('XTR', 50);
        $info = new SuggestedPostInfo('approved', $price, 1234567890);

        assertSame('approved', $info->state);
        assertSame($price, $info->price);
        assertSame(1234567890, $info->sendDate);
    }

    public function testFromTelegramResult(): void
    {
        $info = (new ObjectFactory())->create(
            [
                'state' => 'declined',
                'price' => [
                    'currency' => 'TON',
                    'amount' => 10000000,
                ],
                'send_date' => 1672531200,
            ],
            null,
            SuggestedPostInfo::class,
        );

        assertSame('declined', $info->state);
        assertInstanceOf(SuggestedPostPrice::class, $info->price);
        assertSame('TON', $info->price->currency);
        assertSame(10000000, $info->price->amount);
        assertSame(1672531200, $info->sendDate);
    }

    public function testFromTelegramResultMinimal(): void
    {
        $info = (new ObjectFactory())->create(
            [
                'state' => 'pending',
            ],
            null,
            SuggestedPostInfo::class,
        );

        assertSame('pending', $info->state);
        assertNull($info->price);
        assertNull($info->sendDate);
    }
}
