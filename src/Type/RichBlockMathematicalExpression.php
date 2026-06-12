<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#richblockmathematicalexpression
 *
 * @api
 */
final readonly class RichBlockMathematicalExpression implements RichBlock
{
    public function __construct(
        public string $expression,
    ) {}

    public function getType(): string
    {
        return 'mathematical_expression';
    }
}
