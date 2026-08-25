<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputRichBlockExpandableBlockQuotation;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockExpandableBlockQuotationTest extends TestCase
{
    public function testBase(): void
    {
        $blockQuotation = new InputRichBlockExpandableBlockQuotation('hello');

        assertSame('expandable_blockquote', $blockQuotation->getType());
        assertSame(
            ['type' => 'expandable_blockquote', 'text' => 'hello'],
            $blockQuotation->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $blockQuotation = new InputRichBlockExpandableBlockQuotation('hello', 'credit');

        assertSame(
            ['type' => 'expandable_blockquote', 'text' => 'hello', 'credit' => 'credit'],
            $blockQuotation->toRequestArray(),
        );
    }
}
