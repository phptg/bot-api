<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\UnpinAllGeneralForumTopicMessages;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class UnpinAllGeneralForumTopicMessagesTest extends TestCase
{
    public function testBase(): void
    {
        $method = new UnpinAllGeneralForumTopicMessages(1);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('unpinAllGeneralForumTopicMessages', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new UnpinAllGeneralForumTopicMessages(1);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
