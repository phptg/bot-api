<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetManagedBotAccessSettings;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\BotAccessSettings;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class GetManagedBotAccessSettingsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetManagedBotAccessSettings(123);

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getManagedBotAccessSettings', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 123,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetManagedBotAccessSettings(123);

        $preparedResult = TestHelper::createSuccessStubApi([
            'is_access_restricted' => true,
            'added_users' => [
                ['id' => 1, 'is_bot' => false, 'first_name' => 'Alice'],
            ],
        ])->call($method);

        assertInstanceOf(BotAccessSettings::class, $preparedResult);
        assertSame(true, $preparedResult->isAccessRestricted);
        assertSame(1, $preparedResult->addedUsers[0]->id);
        assertSame('Alice', $preparedResult->addedUsers[0]->firstName);
    }
}
