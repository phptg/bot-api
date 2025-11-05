<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetChatMember;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\ChatMemberMember;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class GetChatMemberTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetChatMember(1, 2);

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getChatMember', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'user_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetChatMember(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi([
            'status' => 'member',
            'user' => ['id' => 23, 'is_bot' => false, 'first_name' => 'Mike'],
        ])->call($method);

        assertInstanceOf(ChatMemberMember::class, $preparedResult);
        assertSame(23, $preparedResult->user->id);
    }
}
