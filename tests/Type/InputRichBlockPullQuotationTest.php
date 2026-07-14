<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputRichBlockPullQuotation;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockPullQuotationTest extends TestCase
{
    public function testBase(): void
    {
        $pullQuotation = new InputRichBlockPullQuotation('hello');

        assertSame('pullquote', $pullQuotation->getType());
        assertSame(
            ['type' => 'pullquote', 'text' => 'hello'],
            $pullQuotation->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $pullQuotation = new InputRichBlockPullQuotation('hello', 'credit');

        assertSame(
            ['type' => 'pullquote', 'text' => 'hello', 'credit' => 'credit'],
            $pullQuotation->toRequestArray(),
        );
    }
}
