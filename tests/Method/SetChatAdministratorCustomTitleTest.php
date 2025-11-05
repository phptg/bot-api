<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SetChatAdministratorCustomTitle;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetChatAdministratorCustomTitleTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetChatAdministratorCustomTitle(1, 2, 'test');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setChatAdministratorCustomTitle', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'user_id' => 2,
                'custom_title' => 'test',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetChatAdministratorCustomTitle(1, 2, 'test');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
