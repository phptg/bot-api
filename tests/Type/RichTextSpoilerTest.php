<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextSpoiler;

use function PHPUnit\Framework\assertSame;

final class RichTextSpoilerTest extends TestCase
{
    public function testBase(): void
    {
        $spoiler = new RichTextSpoiler('hello');

        assertSame('spoiler', $spoiler->getType());
        assertSame('hello', $spoiler->text);
    }

    public function testFromTelegramResult(): void
    {
        $spoiler = (new ObjectFactory())->create([
            'type' => 'spoiler',
            'text' => 'hello',
        ], null, RichTextSpoiler::class);

        assertSame('spoiler', $spoiler->getType());
        assertSame('hello', $spoiler->text);
    }
}
