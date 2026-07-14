<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputRichBlockDivider;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockDividerTest extends TestCase
{
    public function testBase(): void
    {
        $divider = new InputRichBlockDivider();

        assertSame('divider', $divider->getType());
        assertSame(['type' => 'divider'], $divider->toRequestArray());
    }
}
