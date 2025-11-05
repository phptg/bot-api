<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\CreateChatInviteLink;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class CreateChatInviteLinkTest extends TestCase
{
    public function testBase(): void
    {
        $method = new CreateChatInviteLink(23);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('createChatInviteLink', $method->getApiMethod());
        assertSame(['chat_id' => 23], $method->getData());
    }

    public function testFull(): void
    {
        $date = new DateTimeImmutable();
        $method = new CreateChatInviteLink(1, 'hello', $date, 23, false);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('createChatInviteLink', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'name' => 'hello',
                'expire_date' => $date->getTimestamp(),
                'member_limit' => 23,
                'creates_join_request' => false,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new CreateChatInviteLink(1);

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
