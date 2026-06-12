<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockMathematicalExpression;

use function PHPUnit\Framework\assertSame;

final class RichBlockMathematicalExpressionTest extends TestCase
{
    public function testBase(): void
    {
        $expression = new RichBlockMathematicalExpression('E = mc^2');

        assertSame('mathematical_expression', $expression->getType());
        assertSame('E = mc^2', $expression->expression);
    }

    public function testFromTelegramResult(): void
    {
        $expression = (new ObjectFactory())->create([
            'type' => 'mathematical_expression',
            'expression' => 'E = mc^2',
        ], null, RichBlockMathematicalExpression::class);

        assertSame('mathematical_expression', $expression->getType());
        assertSame('E = mc^2', $expression->expression);
    }
}
