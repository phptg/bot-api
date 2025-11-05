<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Game;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Game\GetGameHighScores;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\Game\GameHighScore;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class GetGameHighScoresTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetGameHighScores(1);

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getGameHighScores', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new GetGameHighScores(1, 2, 3, 'test');

        assertSame(
            [
                'user_id' => 1,
                'chat_id' => 2,
                'message_id' => 3,
                'inline_message_id' => 'test',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetGameHighScores(1);

        $preparedResult = TestHelper::createSuccessStubApi([
            [
                'position' => 2,
                'user' => [
                    'id' => 1,
                    'is_bot' => false,
                    'first_name' => 'test',
                ],
                'score' => 300,
            ],
        ])->call($method);

        assertCount(1, $preparedResult);
        assertInstanceOf(GameHighScore::class, $preparedResult[0]);
        assertSame(2, $preparedResult[0]->position);
    }
}
