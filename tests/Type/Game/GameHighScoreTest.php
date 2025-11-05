<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Game;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Game\GameHighScore;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertSame;

final class GameHighScoreTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'test');
        $type = new GameHighScore(2, $user, 300);

        assertSame(2, $type->position);
        assertSame($user, $type->user);
        assertSame(300, $type->score);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'position' => 2,
            'user' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'test',
            ],
            'score' => 300,
        ], null, GameHighScore::class);

        assertSame(2, $type->position);
        assertSame(1, $type->user->id);
        assertSame(300, $type->score);
    }
}
