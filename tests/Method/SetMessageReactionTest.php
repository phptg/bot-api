<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SetMessageReaction;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\ReactionTypeEmoji;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetMessageReactionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetMessageReaction(1, 2);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setMessageReaction', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'message_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $reactionType = new ReactionTypeEmoji('👍');
        $method = new SetMessageReaction(1, 2, [$reactionType], true);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setMessageReaction', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'message_id' => 2,
                'reaction' => [$reactionType->toRequestArray()],
                'is_big' => true,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetMessageReaction(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
