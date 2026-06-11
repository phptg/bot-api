<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextMathematicalExpression;

use function PHPUnit\Framework\assertSame;

final class RichTextMathematicalExpressionTest extends TestCase
{
    public function testBase(): void
    {
        $expression = new RichTextMathematicalExpression('E = mc^2');

        assertSame('mathematical_expression', $expression->getType());
        assertSame('E = mc^2', $expression->expression);
    }

    public function testFromTelegramResult(): void
    {
        $expression = (new ObjectFactory())->create([
            'type' => 'mathematical_expression',
            'expression' => 'E = mc^2',
        ], null, RichTextMathematicalExpression::class);

        assertSame('mathematical_expression', $expression->getType());
        assertSame('E = mc^2', $expression->expression);
    }
}
