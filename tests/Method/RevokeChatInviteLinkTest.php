<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\RevokeChatInviteLink;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class RevokeChatInviteLinkTest extends TestCase
{
    public function testBase(): void
    {
        $method = new RevokeChatInviteLink(1, 'https://t.me/+example');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('revokeChatInviteLink', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'invite_link' => 'https://t.me/+example',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new RevokeChatInviteLink(1, 'https://t.me/+example');

        $preparedResult = TestHelper::createSuccessStubApi([
            'invite_link' => 'https//t.me/+example',
            'creator' => [
                'id' => 23,
                'is_bot' => true,
                'first_name' => 'testBot',
            ],
            'creates_join_request' => true,
            'is_primary' => true,
            'is_revoked' => false,
        ])->call($method);

        assertSame(23, $preparedResult->creator->id);
    }
}
