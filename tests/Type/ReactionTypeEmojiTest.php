<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ReactionTypeEmoji;

use function PHPUnit\Framework\assertSame;

final class ReactionTypeEmojiTest extends TestCase
{
    public function testBase(): void
    {
        $reaction = new ReactionTypeEmoji('👍');

        assertSame('emoji', $reaction->getType());
        assertSame('👍', $reaction->emoji);
        assertSame(
            [
                'type' => 'emoji',
                'emoji' => '👍',
            ],
            $reaction->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $reaction = (new ObjectFactory())->create([
            'type' => 'emoji',
            'emoji' => '👍',
        ], null, ReactionTypeEmoji::class);

        assertSame('emoji', $reaction->getType());
        assertSame('👍', $reaction->emoji);
    }
}
