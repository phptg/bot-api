<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Document;
use Phptg\BotApi\Type\RichBlockCaption;
use Phptg\BotApi\Type\RichBlockDocument;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class RichBlockDocumentTest extends TestCase
{
    public function testBase(): void
    {
        $document = new Document('f123', 'fullF123');
        $block = new RichBlockDocument($document);

        assertSame('document', $block->getType());
        assertSame($document, $block->document);
        assertNull($block->caption);
    }

    public function testFull(): void
    {
        $document = new Document('f123', 'fullF123');
        $caption = new RichBlockCaption('document');
        $block = new RichBlockDocument($document, $caption);

        assertSame('document', $block->getType());
        assertSame($document, $block->document);
        assertSame($caption, $block->caption);
    }

    public function testFromTelegramResult(): void
    {
        $block = (new ObjectFactory())->create([
            'type' => 'document',
            'document' => [
                'file_id' => 'f123',
                'file_unique_id' => 'fullF123',
            ],
        ], null, RichBlockDocument::class);

        assertSame('document', $block->getType());
        assertInstanceOf(Document::class, $block->document);
        assertSame('f123', $block->document->fileId);
        assertNull($block->caption);
    }

    public function testFromTelegramResultFull(): void
    {
        $block = (new ObjectFactory())->create([
            'type' => 'document',
            'document' => [
                'file_id' => 'f123',
                'file_unique_id' => 'fullF123',
            ],
            'caption' => ['text' => 'document'],
        ], null, RichBlockDocument::class);

        assertSame('document', $block->getType());
        assertInstanceOf(Document::class, $block->document);
        assertInstanceOf(RichBlockCaption::class, $block->caption);
        assertSame('document', $block->caption->text);
    }
}
