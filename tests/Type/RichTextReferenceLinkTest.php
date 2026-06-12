<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextReferenceLink;

use function PHPUnit\Framework\assertSame;

final class RichTextReferenceLinkTest extends TestCase
{
    public function testBase(): void
    {
        $referenceLink = new RichTextReferenceLink('hello', 'ref1');

        assertSame('reference_link', $referenceLink->getType());
        assertSame('hello', $referenceLink->text);
        assertSame('ref1', $referenceLink->referenceName);
    }

    public function testFromTelegramResult(): void
    {
        $referenceLink = (new ObjectFactory())->create([
            'type' => 'reference_link',
            'text' => 'hello',
            'reference_name' => 'ref1',
        ], null, RichTextReferenceLink::class);

        assertSame('reference_link', $referenceLink->getType());
        assertSame('hello', $referenceLink->text);
        assertSame('ref1', $referenceLink->referenceName);
    }
}
