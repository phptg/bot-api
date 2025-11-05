<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ReactionCount;
use Phptg\BotApi\Type\ReactionTypeEmoji;

use function PHPUnit\Framework\assertSame;

final class ReactionCountTest extends TestCase
{
    public function testBase(): void
    {
        $reactionType = new ReactionTypeEmoji('👍');
        $count = new ReactionCount($reactionType, 23);

        assertSame($reactionType, $count->type);
        assertSame(23, $count->totalCount);
    }

    public function testFromTelegramResult(): void
    {
        $count = (new ObjectFactory())->create([
            'type' => [
                'type' => 'emoji',
                'emoji' => '👍',
            ],
            'total_count' => 23,
        ], null, ReactionCount::class);

        assertSame('👍', $count->type->emoji);
        assertSame(23, $count->totalCount);
    }
}
