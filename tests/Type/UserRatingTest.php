<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\UserRating;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class UserRatingTest extends TestCase
{
    public function testBase(): void
    {
        $userRating = new UserRating(5, 1000, 800);

        assertSame(5, $userRating->level);
        assertSame(1000, $userRating->rating);
        assertSame(800, $userRating->currentLevelRating);
        assertNull($userRating->nextLevelRating);
    }

    public function testFromTelegramResult(): void
    {
        $userRating = (new ObjectFactory())->create([
            'level' => 5,
            'rating' => 1000,
            'current_level_rating' => 800,
            'next_level_rating' => 1200,
        ], null, UserRating::class);

        assertSame(5, $userRating->level);
        assertSame(1000, $userRating->rating);
        assertSame(800, $userRating->currentLevelRating);
        assertSame(1200, $userRating->nextLevelRating);
    }
}
