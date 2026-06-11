<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextMention;

use function PHPUnit\Framework\assertSame;

final class RichTextMentionTest extends TestCase
{
    public function testBase(): void
    {
        $mention = new RichTextMention('hello', 'johndoe');

        assertSame('mention', $mention->getType());
        assertSame('hello', $mention->text);
        assertSame('johndoe', $mention->username);
    }

    public function testFromTelegramResult(): void
    {
        $mention = (new ObjectFactory())->create([
            'type' => 'mention',
            'text' => 'hello',
            'username' => 'johndoe',
        ], null, RichTextMention::class);

        assertSame('mention', $mention->getType());
        assertSame('hello', $mention->text);
        assertSame('johndoe', $mention->username);
    }
}
