<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputRichBlockMathematicalExpression;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockMathematicalExpressionTest extends TestCase
{
    public function testBase(): void
    {
        $expression = new InputRichBlockMathematicalExpression('E = mc^2');

        assertSame('mathematical_expression', $expression->getType());
        assertSame(
            ['type' => 'mathematical_expression', 'expression' => 'E = mc^2'],
            $expression->toRequestArray(),
        );
    }
}
