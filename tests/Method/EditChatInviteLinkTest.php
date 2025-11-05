<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\EditChatInviteLink;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class EditChatInviteLinkTest extends TestCase
{
    public function testBase(): void
    {
        $method = new EditChatInviteLink(1, 'https://t.me/+example');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editChatInviteLink', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'invite_link' => 'https://t.me/+example',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $date = new DateTimeImmutable();
        $method = new EditChatInviteLink(1, 'https://t.me/+example', 'Hello', $date, 23, false);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editChatInviteLink', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'invite_link' => 'https://t.me/+example',
                'name' => 'Hello',
                'expire_date' => $date->getTimestamp(),
                'member_limit' => 23,
                'creates_join_request' => false,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditChatInviteLink(1, 'https://t.me/+example');

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
