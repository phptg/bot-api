<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\ReopenGeneralForumTopic;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ReopenGeneralForumTopicTest extends TestCase
{
    public function testBase(): void
    {
        $method = new ReopenGeneralForumTopic(1);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('reopenGeneralForumTopic', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new ReopenGeneralForumTopic(2);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
