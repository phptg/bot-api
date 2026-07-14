<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputRichBlockFooter;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockFooterTest extends TestCase
{
    public function testBase(): void
    {
        $footer = new InputRichBlockFooter('hello');

        assertSame('footer', $footer->getType());
        assertSame(
            ['type' => 'footer', 'text' => 'hello'],
            $footer->toRequestArray(),
        );
    }
}
