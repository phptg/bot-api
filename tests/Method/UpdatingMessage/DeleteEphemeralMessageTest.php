<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\UpdatingMessage;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\UpdatingMessage\DeleteEphemeralMessage;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class DeleteEphemeralMessageTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteEphemeralMessage(23, 45, 34);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteEphemeralMessage', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 23,
                'receiver_user_id' => 45,
                'ephemeral_message_id' => 34,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteEphemeralMessage(23, 45, 34);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
