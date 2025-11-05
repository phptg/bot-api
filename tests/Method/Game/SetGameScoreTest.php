<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Game;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Game\SetGameScore;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\Message;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetGameScoreTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetGameScore(1, 2);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setGameScore', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 1,
                'score' => 2,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new SetGameScore(
            1,
            2,
            true,
            false,
            10,
            20,
            'id1',
        );

        assertSame(
            [
                'user_id' => 1,
                'score' => 2,
                'force' => true,
                'disable_edit_message' => false,
                'chat_id' => 10,
                'message_id' => 20,
                'inline_message_id' => 'id1',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetGameScore(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);
        assertTrue($preparedResult);

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->call($method);
        assertInstanceOf(Message::class, $preparedResult);
        assertSame(7, $preparedResult->messageId);
    }
}
