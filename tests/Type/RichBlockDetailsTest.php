<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockDetails;
use Phptg\BotApi\Type\RichBlockParagraph;
use Phptg\BotApi\Type\RichTextBold;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class RichBlockDetailsTest extends TestCase
{
    public function testBase(): void
    {
        $details = new RichBlockDetails('summary', [new RichBlockParagraph('hello')]);

        assertSame('details', $details->getType());
        assertSame('summary', $details->summary);
        assertCount(1, $details->blocks);
        assertNull($details->isOpen);
    }

    public function testFull(): void
    {
        $details = new RichBlockDetails('summary', [new RichBlockParagraph('hello')], true);

        assertSame('details', $details->getType());
        assertSame('summary', $details->summary);
        assertCount(1, $details->blocks);
        assertTrue($details->isOpen);
    }

    public function testFromTelegramResult(): void
    {
        $details = (new ObjectFactory())->create([
            'type' => 'details',
            'summary' => 'summary',
            'blocks' => [
                ['type' => 'paragraph', 'text' => 'hello'],
            ],
        ], null, RichBlockDetails::class);

        assertSame('details', $details->getType());
        assertSame('summary', $details->summary);
        assertCount(1, $details->blocks);
        assertInstanceOf(RichBlockParagraph::class, $details->blocks[0]);
        assertNull($details->isOpen);
    }

    public function testFromTelegramResultFull(): void
    {
        $details = (new ObjectFactory())->create([
            'type' => 'details',
            'summary' => ['type' => 'bold', 'text' => 'summary'],
            'blocks' => [
                ['type' => 'paragraph', 'text' => 'hello'],
            ],
            'is_open' => true,
        ], null, RichBlockDetails::class);

        assertSame('details', $details->getType());
        assertInstanceOf(RichTextBold::class, $details->summary);
        assertSame('summary', $details->summary->text);
        assertCount(1, $details->blocks);
        assertInstanceOf(RichBlockParagraph::class, $details->blocks[0]);
        assertTrue($details->isOpen);
    }
}
