<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputRichBlockPreformatted;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockPreformattedTest extends TestCase
{
    public function testBase(): void
    {
        $preformatted = new InputRichBlockPreformatted('hello');

        assertSame('pre', $preformatted->getType());
        assertSame(
            ['type' => 'pre', 'text' => 'hello'],
            $preformatted->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $preformatted = new InputRichBlockPreformatted('hello', 'php');

        assertSame(
            ['type' => 'pre', 'text' => 'hello', 'language' => 'php'],
            $preformatted->toRequestArray(),
        );
    }
}
