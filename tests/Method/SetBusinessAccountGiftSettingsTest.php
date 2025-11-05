<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SetBusinessAccountGiftSettings;
use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Type\AcceptedGiftTypes;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetBusinessAccountGiftSettingsTest extends TestCase
{
    public function testBase(): void
    {
        $acceptedGiftTypes = new AcceptedGiftTypes(true, false, false, false);
        $method = new SetBusinessAccountGiftSettings(
            'connection1',
            true,
            $acceptedGiftTypes,
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setBusinessAccountGiftSettings', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'connection1',
                'show_gift_button' => true,
                'accepted_gift_types' => $acceptedGiftTypes->toRequestArray(),
            ],
            $method->getData(),
        );
        assertInstanceOf(TrueValue::class, $method->getResultType());
    }

    public function testPrepareResult(): void
    {
        $method = new SetBusinessAccountGiftSettings(
            'connection1',
            true,
            new AcceptedGiftTypes(true, false, false, false),
        );

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
