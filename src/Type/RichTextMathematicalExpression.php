<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#richtextmathematicalexpression
 *
 * @api
 */
final readonly class RichTextMathematicalExpression implements RichText
{
    public function __construct(
        public string $expression,
    ) {}

    public function getType(): string
    {
        return 'mathematical_expression';
    }
}
