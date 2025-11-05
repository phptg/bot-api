<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\UpdatingMessage;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\UpdatingMessage\DeleteMessages;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class DeleteMessagesTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteMessages(1, [2, 3]);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteMessages', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'message_ids' => [2, 3],
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteMessages(1, [2, 3]);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
