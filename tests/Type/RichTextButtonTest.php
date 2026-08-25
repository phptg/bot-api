<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockParagraph;
use Phptg\BotApi\Type\RichMessageButton;
use Phptg\BotApi\Type\RichTextButton;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class RichTextButtonTest extends TestCase
{
    public function testBase(): void
    {
        $button = new RichMessageButton('test', callbackData: 'data');
        $richText = new RichTextButton($button);

        assertSame('button', $richText->getType());
        assertSame($button, $richText->button);
        assertSame(
            [
                'type' => 'button',
                'button' => [
                    'text' => 'test',
                    'callback_data' => 'data',
                ],
            ],
            $richText->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $richText = (new ObjectFactory())->create([
            'type' => 'button',
            'button' => [
                'text' => 'test',
                'callback_data' => 'data',
            ],
        ], null, RichTextButton::class);

        assertSame('button', $richText->getType());
        assertInstanceOf(RichMessageButton::class, $richText->button);
        assertSame('test', $richText->button->text);
        assertSame('data', $richText->button->callbackData);
    }

    public function testFromTelegramResultViaRichTextValue(): void
    {
        $block = (new ObjectFactory())->create([
            'type' => 'paragraph',
            'text' => [
                'type' => 'button',
                'button' => ['text' => 'test'],
            ],
        ], null, RichBlockParagraph::class);

        assertInstanceOf(RichTextButton::class, $block->text);
    }
}
