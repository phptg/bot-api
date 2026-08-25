<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
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
}
