<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SetManagedBotAccessSettings;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetManagedBotAccessSettingsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetManagedBotAccessSettings(123, true);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setManagedBotAccessSettings', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 123,
                'is_access_restricted' => true,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new SetManagedBotAccessSettings(123, true, [456, 789]);

        assertSame(
            [
                'user_id' => 123,
                'is_access_restricted' => true,
                'added_user_ids' => [456, 789],
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetManagedBotAccessSettings(123, true);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
