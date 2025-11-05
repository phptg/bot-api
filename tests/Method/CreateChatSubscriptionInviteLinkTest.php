<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\CreateChatSubscriptionInviteLink;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class CreateChatSubscriptionInviteLinkTest extends TestCase
{
    public function testBase(): void
    {
        $method = new CreateChatSubscriptionInviteLink(10, 20, 30);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('createChatSubscriptionInviteLink', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 10,
                'subscription_period' => 20,
                'subscription_price' => 30,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new CreateChatSubscriptionInviteLink(10, 20, 30, 'test');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('createChatSubscriptionInviteLink', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 10,
                'name' => 'test',
                'subscription_period' => 20,
                'subscription_price' => 30,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new CreateChatSubscriptionInviteLink(1, 2, 3);

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
