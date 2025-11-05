<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\SuggestedPostParameters;
use Phptg\BotApi\Type\SuggestedPostPrice;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class SuggestedPostParametersTest extends TestCase
{
    public function testBase(): void
    {
        $parameters = new SuggestedPostParameters();

        assertNull($parameters->price);
        assertNull($parameters->sendDate);
        assertSame([], $parameters->toRequestArray());
    }

    public function testFull(): void
    {
        $parameters = new SuggestedPostParameters(
            price: new SuggestedPostPrice('XTR', 50),
            sendDate: 1620000300,
        );

        assertSame(
            [
                'price' => [
                    'currency' => 'XTR',
                    'amount' => 50,
                ],
                'send_date' => 1620000300,
            ],
            $parameters->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $parameters = (new ObjectFactory())->create(
            [
                'price' => [
                    'currency' => 'XTR',
                    'amount' => 100,
                ],
                'send_date' => 1620000300,
            ],
            null,
            SuggestedPostParameters::class,
        );

        assertSame('XTR', $parameters->price?->currency);
        assertSame(100, $parameters->price?->amount);
        assertSame(1620000300, $parameters->sendDate);
    }
}
