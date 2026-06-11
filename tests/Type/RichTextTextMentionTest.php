<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextTextMention;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertSame;

final class RichTextTextMentionTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'John');
        $textMention = new RichTextTextMention('hello', $user);

        assertSame('text_mention', $textMention->getType());
        assertSame('hello', $textMention->text);
        assertSame($user, $textMention->user);
    }

    public function testFromTelegramResult(): void
    {
        $textMention = (new ObjectFactory())->create([
            'type' => 'text_mention',
            'text' => 'hello',
            'user' => ['id' => 123, 'is_bot' => false, 'first_name' => 'John'],
        ], null, RichTextTextMention::class);

        assertSame('text_mention', $textMention->getType());
        assertSame('hello', $textMention->text);
        assertSame(123, $textMention->user->id);
        assertSame('John', $textMention->user->firstName);
    }
}
