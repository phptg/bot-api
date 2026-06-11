<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockThinking;
use Phptg\BotApi\Type\RichTextBold;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class RichBlockThinkingTest extends TestCase
{
    public function testBase(): void
    {
        $thinking = new RichBlockThinking('thinking...');

        assertSame('thinking', $thinking->getType());
        assertSame('thinking...', $thinking->text);
    }

    public function testFromTelegramResult(): void
    {
        $thinking = (new ObjectFactory())->create([
            'type' => 'thinking',
            'text' => 'thinking...',
        ], null, RichBlockThinking::class);

        assertSame('thinking', $thinking->getType());
        assertSame('thinking...', $thinking->text);
    }

    public function testFromTelegramResultFull(): void
    {
        $thinking = (new ObjectFactory())->create([
            'type' => 'thinking',
            'text' => ['type' => 'bold', 'text' => 'thinking...'],
        ], null, RichBlockThinking::class);

        assertSame('thinking', $thinking->getType());
        assertInstanceOf(RichTextBold::class, $thinking->text);
        assertSame('thinking...', $thinking->text->text);
    }
}
