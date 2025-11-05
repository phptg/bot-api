<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SetChatDescription;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetChatDescriptionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetChatDescription(1);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setChatDescription', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new SetChatDescription(1, 'test');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setChatDescription', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'description' => 'test',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetChatDescription(1);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
