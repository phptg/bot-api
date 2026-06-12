<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextReference;

use function PHPUnit\Framework\assertSame;

final class RichTextReferenceTest extends TestCase
{
    public function testBase(): void
    {
        $reference = new RichTextReference('hello', 'ref1');

        assertSame('reference', $reference->getType());
        assertSame('hello', $reference->text);
        assertSame('ref1', $reference->name);
    }

    public function testFromTelegramResult(): void
    {
        $reference = (new ObjectFactory())->create([
            'type' => 'reference',
            'text' => 'hello',
            'name' => 'ref1',
        ], null, RichTextReference::class);

        assertSame('reference', $reference->getType());
        assertSame('hello', $reference->text);
        assertSame('ref1', $reference->name);
    }
}
