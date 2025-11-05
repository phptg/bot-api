<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetChat;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class GetChatTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetChat(99);

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getChat', $method->getApiMethod());
        assertSame(['chat_id' => 99], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetChat(99);

        $preparedResult = TestHelper::createSuccessStubApi([
            'id' => 23,
            'type' => 'private',
            'accent_color_id' => 0x123456,
            'max_reaction_count' => 5,
        ])->call($method);

        assertSame(23, $preparedResult->id);
    }
}
